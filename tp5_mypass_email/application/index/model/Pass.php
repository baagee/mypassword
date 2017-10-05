<?php
namespace app\index\model;

use think\Model;

class Pass extends Model{
    protected $table='pass';

    protected $createTime='create_at';
    protected $updateTime='update_at';

    protected $type=[
        'create_at'=>'timestamp:Y-m-d H:i:s',
        'update_at'=>'timestamp:Y-m-d H:i:s',
    ];


    //	定义自动完成的属性
    protected	$insert	=	['uuid','userid'];

    //	uuid属性修改器
    protected function setUuidAttr(){
        return	uniqid();
    }

    // userid修改器
    protected function setUseridAttr(){
        return session('user')->id;
    }

    // 添加修改用户密码修改器
    protected function setPasswordAttr($pass){
        $userKey=session('user')->key;
        return authCode($pass,'ENCODE',$userKey,0);
    }

    //  获取用户密码时解码
    protected function getPasswordAttr($pass){
//        特殊情况下采用旧的用户key
        $userKey=session('i')?session('user')->oldKey:session('user')->key;
        return authCode($pass,'DECODE',$userKey,0);
    }


}
