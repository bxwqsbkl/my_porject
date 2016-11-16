<?php
return array(
    //'配置项'=>'配置值'
    'URL_MODEL' => 2,//http形式 pathinfo
    /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'php0813_shop',   // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  3306,        // 端口
    'DB_PREFIX'             =>  'shop_',    // 数据库表前缀
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    'SHOW_PAGE_TRACE' =>true,
    'DB_PARAMS' =>[ PDO::ATTR_CASE=>PDO::CASE_NATURAL], // 数据库连接参数
    'TMPL_PARSE_STRING' =>  array(
        '__CSS__'   => '/Public/Styles',
        '__JS__'   => '/Public/Js',
        '__IMG__'   => '/Public/Images',
        '__UPLOADIFY__'=>'/Public/ext/uploadify',
        '__LAYER__'=>'/Public/ext/layer',
        '__BAIDU__'=>'/Public/ext/ueditor',
        '__ZTREE__'=>'/Public/ext/ztree',
    ),
    'PAGE'=>[
        'SIZE'=>10,
        'THEME'=>'%FIRST% %HEADER% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%'
    ],
    'BASE_URL'=>'http://admin.shop.com/',
    'RBAC'=>[
        'IGNORE'=>[
            'Admin/Admin/login',
            'Admin/Captcha/show',
        ],
        'USER_IGNORE'=>[
            'Admin/Index/index',
            'Admin/Index/top',
            'Admin/Index/menu',
            'Admin/Index/main',
            'Admin/Admin/logout',
            'Admin/Editor/ueditor',
            'Admin/Upload/upload',
        ]
    ],
    'COOKIE_PREFIX'  => 'admin_shop_com_',//设置cookie前缀
);