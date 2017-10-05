<?php
namespace app\index\controller;
use app\index\model\Pass;
use app\index\model\User;
use smsSend\smsSend;
use think\Controller;
use think\Request;
use think\Validate;


class Index extends Controller{

    public function __construct(Request $request){
        parent::__construct($request);
        if(empty(session('user'))){
//            除了这些方法不需要登录
            if(!in_array($this->request->action(),array('login','sendcode','register','checkemail'))){
                $this->redirect('/user/login');
            }
        }
    }

    /**
     * 用户登录
     * @return \think\response\View
     */
    public function login(){
        if($this->request->isAjax()){
            if(trim(input('code'))=='' || strtolower(session('code'))!=strtolower(trim(input('code')))){
                return json(['status'=>0,'msg'=>'验证码错误']);
            }
            $userModel=new User();
            $user=$userModel->where(['email'=>input('email'),'password'=>makePassword(input('pass'))])->find();
            if(!$user){
                return json(['status'=>0,'msg'=>'用户名或者密码错误']);
            }else{
//                保存旧密钥
                $user->oldKey=$user->key;
                session('user',$user);
                session('code',null);
                // 发送邮件通知
                $title='蘑菇头密码管理器-登录提示';
                $content='您好，您刚才登陆了蘑菇头密码管理器，如果不是您本人登录请及时修改哦';
                sendMail($user->email,$title,$content);
                return json(['status'=>1,'msg'=>'登陆成功']);
            }
        }
        return view('login');
    }

    /**
     * 用户退出
     */
    public function logout(){
        session('user',null);
        $this->redirect('/user/login');
    }

    /**
     * 用户注册
     * @return \think\response\View
     */
    public function register(){
        if($this->request->isAjax()){
            if(!Validate::is(input('key'),'require')){
                return json(['status'=>0,'msg'=>'密钥不能为空']);
            }
            if(input('code')=='' || strtolower(session('code'))!=strtolower(input('code'))){
                return ['status'=>0,'msg'=>'验证码错误'];
            }
            $userModel=new User();
            if($userModel->allowField(true)->validate(true)->save(input('post.'))){
                session('code',null);
                return json(['status'=>1,'msg'=>'注册成功']);
            }else{
                return json(['status'=>0,'msg'=>$userModel->getError()]);
            }
        }
        return view('register');
    }


    /**
     * 验证邮箱
     * @return string|\think\response\Json
     */
    public function checkEmail(){
        if($this->request->isAjax()){
            if(!Validate::is(input('email'),'email')){
                return json(['status'=>0,'msg'=>'此邮箱格式不正确']);
            }
            $userModel=new User();
            if($userModel->getByEmail(input('email'))){
                return json(['status'=>0,'msg'=>'此邮箱已被使用，请更换邮箱']);
            }else{
                return json(['status'=>1,'msg'=>'此邮箱可用']);
            }
        }else{
            return '不正当访问';
        }
    }

    /**
     * 发送验证码
     * email
     */
    public function sendCode(){
        if($this->request->isAjax()){
            if(!Validate::is(input('email'),'email')){
                return json(['status'=>0,'msg'=>'此邮箱格式不正确']);
            }
            $title='蘑菇头密码管理器-邮箱验证码';
            $code=createCode();
            session('code',$code);
            $content='您好，您的邮箱验证码是：<br><span style="color:red">'.$code.'</span><hr>为了安全，请不要告诉其他人哦~_~';
            if($res=sendMail(input('email'),$title,$content)){
                return json(['status'=>1,'msg'=>'发送成功，如果没收到请翻翻垃圾箱哦']);
            }else{
                return json(['status'=>0,'msg'=>'发送失败，原因：'.$res]);
            }
        }else{
            return '不正当访问';
        }
    }

    /**
     * 密码列表
     * @return \think\response\View
     */
    public function index(){
        $passModel=new Pass();
        $list=$passModel->where(array('userid'=>session('user')->id))->order('id','desc')->select();
        $count=$passModel->where(['userid'=>session('user')->id])->count();
        $info='您当前共存了<span id="passcount">'.$count.'</span>条密码。';
        return view('index',['title'=>'查看密码','list'=>$list,'info'=>$info]);
    }

    /**
     * 添加密码
     * @return \think\response\View
     */
    public function addPass(){
        if($this->request->isAjax()){
            $passModel=new Pass();
            if($passModel->allowField(true)->validate(true)->save(input('post.'))){
                return json(['status'=>1,'msg'=>'添加成功']);
            }else{
                return json(['status'=>0,'msg'=>$passModel->getError()]);
            }
        }
        return view('addpass',['title'=>'添加密码']);
    }

    /**
     * 删除密码
     * @return string|\think\response\Json
     */
    public function deletePass(){
        if($this->request->isAjax()){
            $passModel=new Pass();
            $pass=$passModel->where(array('uuid'=>input('post.pid')))->find();
            if($pass){
                $pass->delete();
                return json(['status'=>1,'msg'=>'删除成功']);
            }else{
                return json(['status'=>0,'msg'=>$passModel->getError()]);
            }
        }else{
            return '不正当访问';
        }
    }

    /**
     * 编辑密码
     * @param $pid
     * @return string|\think\response\View
     */
    public function editPass($pid){
        if(!empty($pid)){
            $pass=(new Pass())->where(['uuid'=>$pid])->find();
            return view('editpass',['pass'=>$pass,'title'=>'修改密码']);
        }else{
            return '不正当访问';
        }
    }

    /**
     * 编辑保存密码
     * @return string|\think\response\Json
     */
    public function editSave(){
        if($this->request->isAjax()){
            $pass=(new Pass())->where(array('uuid'=>input('pid')))->find();
            $pass->name=input('name');
            $pass->username=input('username');
            $pass->password=input('password');
            $pass->remark=input('remark');
            if($pass->save()){
                return json(['status'=>1,'msg'=>'保存成功']);
            }else{
                return json(['status'=>1,'msg'=>$pass->getError()]);
            }
        }else{
            return '不正当访问';
        }
    }

    /**
     * 个人设置
     * @return \think\response\View
     */
    public function personalSet(){
        if($this->request->isAjax()){
            $user=(new User())->find(session('user')->id);
            if(input('usa')=='password'){
                // 修改密码
                if(makePassword(trim(input('opassword')))!=$user->password){
                    return json(['status'=>0,'msg'=>'旧密码错误']);
                }
                $user->password=trim(input('password'));
            }else if(input('usa')=='key'){
                $user->key=input('key');
            }else if(input('usa')=='email'){
                // 修改登录邮箱
                if(trim(input('code'))=='' || strtolower(session('code'))!=strtolower(trim(input('code')))){
                    return json(['status'=>0,'msg'=>'验证码错误']);
                }
                session('code',null);
                $user->email=input('email');
            }
            if($user->save()){
                $oldKey=session('user')->key;
                $user->oldKey=$oldKey;
                session('user',$user);
                if(input('usa')=='key'){
                    session('i',1);
                    // 重新修改该用户所有加密的密码
                    $passwords=(new Pass())->field('id,password')->where(array('userid'=>session('user')->id))->select();
                    foreach ($passwords as $key => $password) {
                        $pass=(new Pass())->where(['id'=>$password->id])->find();
                        $pass->password=$password->password;
                        $pass->save();
                    }
                    session('i',null);
                }
                return json(['status'=>1,'msg'=>'修改成功']);
            }else{
                return json(['status'=>0,'msg'=>'修改失败']);
            }

        }else{
            return view('personalset',['title'=>'个人设置']);
        }
    }


}
