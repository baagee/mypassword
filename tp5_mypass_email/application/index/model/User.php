<?php
namespace app\index\model;
use think\Model;

class User extends Model{
    protected $table='user';

//    设置时间字段
    protected $createTime='create_at';
    protected $updateTime='update_at';

//    时间格式自动转换
    protected $type=[
        'create_at'=>'timestamp:Y-m-d H:i:s',
        'update_at'=>'timestamp:Y-m-d H:i:s',
    ];

    /**
     * 入库前密码加密
     * @param $pwd
     * @return string
     */
    public function setPasswordAttr($pwd){

        return makePassword($pwd);
    }

    /**
     * 用户key入库前可逆性加密
     * @param $key
     * @return string
     */
    public function setKeyAttr($key){
        return authCode($key,'ENCODE',config('common_key'),0);
    }

    /**
     * 获取用户加密后解密的key
     * @param $key
     * @return string
     */
    public function getKeyAttr($key){
        return authCode($key,'DECODE',config('common_key'),0);
    }



}