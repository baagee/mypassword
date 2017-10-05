<?php

namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    // 系统密钥
    private $key = '8thugnfma()_%$^%&%&*":>"eoyitghfbn_)(*^&%$#@#$$^%%gskmgeiop6tygfbnqm    -t9jr';

    public function __construct(){
        parent::__construct();
        if(empty(session('user'))){
            if(!in_array(ACTION_NAME,array('login','sendcode','register','checkemail'))){
                $this->redirect('index/login');
            }
        }
    }

    /**
     * 生成随机字符串
     */
    private function createCode($length=4) {
        $chars ='abcdefghijklmnopqrstuvwxyz0123456789'; 
        $code = ''; 
        for($i = 0; $i < $length; $i++){ 
            $code.=$chars[mt_rand(0, strlen($chars)-1)]; 
        }
        return $code; 
    } 

    /**
     * 登录用的加密方法
     */
    private function makePassword($password){
        return md5(md5($password.'BaAGee!@#$%^&*(').'hsgireb877867t@#$%^&*');
    }

    /**
     * 可逆性加密解密
     */
    private function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;
        $key = md5($key ? $key: $GLOBALS['discuz_auth_key']);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result.= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }

    /**
     * 发送邮件
     */
    private function sendMail($email,$title,$content){
        vendor('PHPMailer.class#phpmailer');
        $mail = new \PHPMailer();
        if (C('MAIL_SMTP')) {
            $mail->IsSMTP();
        }
        $mail->Host = C('MAIL_SMTP')['MAIL_HOST'];
        $mail->SMTPAuth = C('MAIL_SMTP')['MAIL_SMTPAUTH'];
        $mail->Username = C('MAIL_SMTP')['MAIL_USERNAME'];
        $mail->Password = C('MAIL_SMTP')['MAIL_PASSWORD'];
        $mail->CharSet = C('MAIL_SMTP')['MAIL_CHARSET'];
        $mail->From = C('MAIL_SMTP')['MAIL_FROM'];
        $mail->AddAddress($email);
        $mail->IsHTML(C('MAIL_SMTP')['MAIL_ISHTML']);
        $mail->FromName = C('MAIL_SMTP')['MAIL_FROMNAME'];
        $mail->Subject = $title;
        $mail->Body = $content;
        if (!$mail->Send()) {
            return $mail->ErrorInfo;
        } else {
            return TRUE;
        }
    }

    /**
     * 检测邮箱是否可用
     */
    public function checkEmail(){
        if(IS_AJAX){
            $email=trim(I('post.email'));
            if(!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$email)){ 
                $this->ajaxReturn(array('status'=>0,'msg'=>'邮箱格式不正确'));
            }
            if(M('user')->where(array('email'=>$email))->select()){
                $this->ajaxReturn(array('status'=>0,'msg'=>'此邮箱已被使用，请更换邮箱'));
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>'此邮箱可用'));
        }
    }

    /**
     * 用户注册
     */
    public function register(){
        if(IS_AJAX){
            if(trim(I('post.code'))=='' || strtolower(session('code'))!=strtolower(trim(I('post.code')))){
                $this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
            }
            $userkey=$this->authcode(trim(I('post.key')),'ENCODE',$this->key,0);
            $add=array('email'=>I('post.email'),'password'=>$this->makePassword(trim(I('post.pass'))),'key'=>$userkey);
            if(M('user')->add($add)){
                $this->ajaxReturn(array('status'=>1,'msg'=>'注册成功，您现在要登录吗？'));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'注册失败'));
            }
        }
        $this->display();
    }

    /**
     * 修改密码
     */
    public function deletepass(){
        if(IS_AJAX){
            if(M('pass')->where(array('uuid'=>I('post.pid'),'user_id'=>session('user')[0]['id']))->delete()){
                $this->ajaxReturn(array('status'=>1,'msg'=>'删除完成'));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'删除失败'));
            }
        }
    }

    /**
     * 首页，查看密码
     */
    public function index(){
        $where=array('user_id'=>session('user')[0]['id']);
        $pass=M('pass')->where($where)->select();
        $userkey=session('user')[0]['key'];
        $realkey=$this->authcode($userkey,'DECODE',$this->key,0);
        foreach ($pass as $key => $pa) {
            // 私有密钥
            $pass[$key]['real']=$this->authcode($pa['password'],'DECODE',$realkey,0);
        }
        $this->count=M('pass')->where($where)->count();
        $this->info='您当前共存了<span id="passcount">'.$this->count.'</span>条密码。';
        $this->title='查看密码';
        $this->pass=$pass;
        $this->display();
    }

    /**
     * 退出
     */
    public function logout(){
        session('user',null);
        $this->redirect('login');
    }

    /**
     * 更新密码
     */
    public function updatePasses(){
        $userkey=session('user')[0]['key'];
        $realkey=$this->authcode($userkey,'DECODE',$this->key,0);
        if(IS_AJAX){
            $update=I('post.');
            $pid=$update['pid'];
            if(empty($update['username'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'用户名不能为空'));
            }
            if(empty($update['password'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'密码不能为空'));
            }
            if(empty($update['name'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'密码名称不能为空'));
            }
            if(empty($update['remark'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'备注说明不能为空'));
            }
            // 私有密钥
            $update['password']=$this->authcode($update['password'],'ENCODE',$realkey,0); //加密 
            $update['create_time']=time();
            unset($update['uuid']);
            if(M('pass')->where(array('uuid'=>$pid,'user_id'=>session('user')[0]['id']))->save($update)){
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改完成'));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改失败'));
            }
        }
        $pid=I('get.pid');
        $pass=M('pass')->where(array('uuid'=>$pid,'user_id'=>session('user')[0]['id']))->find();
        // 私有密钥
        $pass['real']=$this->authcode($pass['password'],'DECODE',$realkey,0);
        $this->pass=$pass;
        $this->title='修改密码';
        $this->display();
    }

    /**
     * 添加密码
     */
    public function addPass(){
        if(IS_AJAX){
            $insert=I('post.');
            if(empty($insert['username'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'用户名不能为空'));
            }
            if(empty($insert['password'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'密码不能为空'));
            }
            if(empty($insert['name'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'密码名称不能为空'));
            }
            if(empty($insert['remark'])){
                $this->ajaxReturn(array('status'=>0,'msg'=>'备注说明不能为空'));
            }
            // 私有密钥
            $userkey=session('user')[0]['key'];
            $realkey=$this->authcode($userkey,'DECODE',$this->key,0);
            $insert['password']=$this->authcode($insert['password'],'ENCODE',$realkey,0); //加密 
            $insert['create_time']=time();
            $insert['uuid']=uniqid();
            $insert['user_id']=session('user')[0]['id'];
            if(M('pass')->add($insert)){
                $this->ajaxReturn(array('status'=>1,'msg'=>'添加完成'));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'添加失败'));
            }
        }
        $this->title='添加密码';
        $this->display();   
    }

    /**
     * 个人设置
     */
    public function personalSet(){
        // 重新保存用户信息
        $thisUser=M('user')->where('id='.session('user')[0]['id'])->select();
        session('user',$thisUser);
        // 加密后的用户key
        $oldkey=session('user')[0]['key'];
        $this->realoldkey=$this->authcode($oldkey,'DECODE',$this->key,0);
        if(IS_AJAX){
            if(I('post.usa')=='password'){
                // 修改密码
                if($this->makePassword(trim(I('post.opassword')))!=session('user')[0]['password']){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'旧密码错误'));
                }
                $newPass=$this->makePassword(trim(I('post.password')));
                $save=array('id'=>session('user')[0]['id'],'password'=>$newPass);
            }else if(I('post.usa')=='key'){
                // 修改用户密钥 密钥用系统密钥加密储存
                $newKey=$this->authcode(I('post.key'),'ENCODE',$this->key,0);
                $save=array('id'=>session('user')[0]['id'],'key'=>$newKey);
            }else if(I('post.usa')=='email'){
                // 修改登录邮箱
                if(trim(I('post.code'))=='' || strtolower(session('code'))!=strtolower(trim(I('post.code')))){
                    $this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
                }
                session('code',null);
                $save=array('id'=>session('user')[0]['id'],'email'=>I('post.email'));
            }
            if(M('user')->save($save)){
                if(I('post.usa')=='key'){
                    // 重新修改该用户所有加密的密码
                    $passwords=M('pass')->field('id,password')->where(array('user_id'=>session('user')[0]['id']))->select();
                    foreach ($passwords as $key => $password) {
                        // 根据旧密钥算出真实密码
                        $realPassword=$this->authcode($password['password'],'DECODE',$this->realoldkey,0);
                        // 真实密码被新密钥加密储存
                        $newPassword=$this->authcode($realPassword,'ENCODE',I('post.key'),0);
                        $res=M('pass')->where(array('id'=>$password['id']))->save(array('password'=>$newPassword));
                    }
                }
                // 重新保存用户信息
                $thisUser=M('user')->where('id='.session('user')[0]['id'])->select();
                session('user',$thisUser);
                $this->ajaxReturn(array('status'=>1,'msg'=>'修改成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'修改失败'));
            }
        }
        
        $this->title='个人设置';
        $this->display();
    }

    /**
     * 登录
     */
    public function login(){
        if(IS_AJAX){
            if(trim(I('post.code'))=='' || strtolower(session('code'))!=strtolower(trim(I('post.code')))){
                $this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
            }
            $pass=$this->makePassword(trim(I('post.pass')));
            $user=M('user')->where(array('email'=>I('post.email'),'password'=>$pass))->select();
            if($user){
                session('user',$user);
                session('code',null);
                // 发送邮件通知
                $title='蘑菇头密码管理器-登录提示';
                $content='您好，您刚才登陆了蘑菇头密码管理器，如果不是您本人登录请及时修改哦';
                $this->sendMail($user[0]['email'],$title,$content);
                $this->ajaxReturn(array('status'=>1,'msg'=>'登录成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'用户名或者密码错误'));
            }
        }
        $this->display();
    }

    /**
     * 发送验证码
     */
    public function sendCode(){
        if(IS_AJAX){
            $email=trim(I('post.email'));
            if(empty($email)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'邮箱不能为空'));
            }
            if(!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$email)){ 
                $this->ajaxReturn(array('status'=>0,'msg'=>'邮箱格式不正确'));
            }
            $title='蘑菇头密码管理器-邮箱验证码';
            $code=$this->createCode();
            session('code',$code);
            $content='您好，您的邮箱验证码是：<br><span style="color:red">'.$code.'</span><hr>为了安全，请不要告诉其他人哦~_~';
            if($res=$this->sendMail($email,$title,$content)){
                $this->ajaxReturn(array('status'=>1,'msg'=>'发送成功，如果没收到请翻翻垃圾箱哦'));
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>'发送失败，原因：'.$res));
            }
        }
    }
}