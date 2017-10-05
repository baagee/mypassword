<?php
return array(
	//显示页面跟踪信息
    // 'SHOW_PAGE_TRACE'=>true,
    'DEFAULT_CHARSET'       =>  'utf-8', // 默认输出编码
    //默认分组设置
    'MULTI_MODULE' => false,
    'DEFAULT_MODULE'        =>  'Home',  // 默认模块
    'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    'DEFAULT_ACTION'        =>  'index', // 默认操作名称
    'MODULE_ALLOW_LIST'     =>  array('Home'),   //可供访问的分组
    'URL_CASE_INSENSITIVE'  =>  true,   //url不区分大小写
    //数据库配置
    'DB_TYPE'               =>  'mysqli',
    'DB_HOST'               =>  '127.0.0.1',
    'DB_NAME'               =>  'mypass',
    'DB_USER'               =>  'root',
    'DB_PWD'                =>  '********',
    'HTML_FILE_SUFFIX'=>'.html',
    // 'URL_MODEL'=>'2',
    /*错误页面*/
    'ERROR_PAGE' =>'/Public/404/error.html',
    // 配置邮件发送服务器
    'MAIL_SMTP'=>array(
        'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
        'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
        'MAIL_USERNAME' =>'****',//你的邮箱名
        'MAIL_FROM' =>'*****@163.com',//发件人地址
        'MAIL_FROMNAME'=>'蘑菇头密码管理',//发件人姓名
        'MAIL_PASSWORD' =>'*********',//邮箱密码
        'MAIL_CHARSET' =>'utf-8',//设置邮件编码
        'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件
    ),
);