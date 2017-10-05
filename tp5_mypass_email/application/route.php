<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [

//    用户注册
    'user/register'=>[
        'index/index/register',
        ['method'=>'POST|GET'],
    ],

//    用户登录
    'user/login'=>[
        'index/index/login',
        ['method'=>'POST|GET'],
    ],

    //    用户退出
    'user/logout'=>[
        'index/index/logout',
        ['method'=>'GET'],
    ],

//    检查邮箱
    'index/checkemail'=>[
        'index/index/checkemail',
        ['method'=>'POST'],
    ],

//    发送验证码
    '/index/sendcode'=>[
        'index/index/sendcode',
        ['method'=>'POST'],
    ],

//    查看密码列表
    '/pass/index'=>[
        'index/index/index',
        ['method'=>'get']
    ],

//    添加密码
    'pass/add'=>[
        'index/index/addpass',
        ['method'=>'GET|POST']
    ],

//    删除密码
    '/pass/delete'=>[
        'index/index/deletepass',
        ['method'=>'POST']
    ],

//    编辑密码
    '/pass/edit/:pid'=>[
        'index/index/editpass',
        ['method'=>'GET']
    ],

//    编辑密码保存api
    '/pass/editsave'=>[
        'index/index/editSave',
        ['method'=>'POST']
    ],

    '/user/set'=>[
        'index/index/personalset',
        ['method'=>'POST|GET']
    ]

];
