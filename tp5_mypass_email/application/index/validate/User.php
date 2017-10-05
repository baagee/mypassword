<?php
namespace app\index\validate;
use think\Validate;

class User extends Validate{
    protected $rule=[
        ['password',	'require|min:6',    '密码不能为空|密码不能短于6个字符'],
        ['email',	'email',	'邮箱格式错误']
    ];

}