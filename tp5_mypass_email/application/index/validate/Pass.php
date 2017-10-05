<?php
namespace app\index\validate;
use think\Validate;

class Pass extends Validate{
    protected $rule=[
        ['username',	'require',    '用户名不能为空'],
        ['password',	'require',    '密码不能为空'],
        ['name',	'require',    '密码名字不能为空'],
        ['remark',	'require',    '备注说明不能为空'],
    ];
}