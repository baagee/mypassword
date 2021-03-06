<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use PHPMailer\PHPMailer;

/**
 * 生成随机字符串
 * @param int $length
 * @return string
 */
function createCode($length=4) {
    $chars ='abcdefghijklmnopqrstuvwxyz0123456789';
    $code = '';
    for($i = 0; $i < $length; $i++){
        $code.=$chars[mt_rand(0, strlen($chars)-1)];
    }
    return $code;
}

/**
 * 登录用的加密方法
 * @param $password
 * @return string
 */
function makePassword($password){
    return md5(md5($password.'BaAGee!@#$%^&*(').'hsgireb877867t@#$%^&*');
}

/**
 * 可逆性加密解密
 * @param $string
 * @param string $operation
 * @param string $key
 * @param int $expiry
 * @return string
 */
function authCode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
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
 * @param $email
 * @param $title
 * @param $content
 * @return bool|string
 * @throws \PHPMailer\phpmailerException
 */
function sendMail($email,$title,$content){
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $C=config('mail');
    $mail->Host = $C['mail_host'];
    $mail->SMTPAuth = $C['mail_smtpauth'];
    $mail->Username = $C['mail_username'];
    $mail->Password = $C['mail_password'];
    $mail->CharSet = $C['mail_charset'];
    $mail->From = $C['mail_from'];
    $mail->AddAddress($email);
    $mail->IsHTML($C['mail_ishtml']);
    $mail->FromName = $C['mail_fromname'];
    $mail->Subject = $title;
    $mail->Body = $content;
    if (!$mail->Send()) {
        return $mail->ErrorInfo;
    } else {
        return TRUE;
    }
}