<?php
/**
 * 系统配置
 */
return [
    'pwd_salt' => '&KJHYY*(**……TH（*Y&YYHU', //密码盐值
    'captcha_exp' => 30, //登录验证码有效期30分钟
    'token_jwt_key' => 'QLFZ20210308',
    'token_exp' => 24*30,//登录token时间，单位小时
    'token_valid_exp' => 30, //分钟
    'login_pwd_error_exp' => 24, //登录密码错误锁定时间 单位小时
    'login_pwd_error_num' => 5, //登录密码可错误次数
    'give_vip_grade_id' => 1,//赠送免费权益等级id
    'give_vip_grade_id_002' => 3,//赠送免费权益等级id
    'pdf_url' => 'https://f.5000aaa.com',//pdf文件存储url
    'is_test_pay' => true,//是否开启测试支付

    //登录入口配置
    'loadPlatPassport' => [
        1 => 'logic\admin\Passport', //总后台入口
        2 => 'logic\school\Passport', //校方后台入口
        3 => '', //代理后台入口
        4 => 'logic\member\Passport', //微信小程序入口
        5 => 'logic\member\Passport', //pc入口
    ],
    //登录平台对应参数，用户区别生成的token
    'loadPlatList' => [
        1 => 'admin',
        2 => 'school',
        3 => '',
        4 => 'wxApplets',
        5 => 'pcUser',
    ],

    //api限制次数
    'RsaConfig'=>[
        'limit'=>10, //限制次数
        'timenum'=>60*2, //请求限制后 过期时间
        'interval'=>3, //请求间隔
    ],

    /**
     * 第三方登录授权的配置
     */
    'oauth' => [
        'wx_applets' => array(
            'appid'    => 'wx58d6104ff75296e9',
            'appsecret' => 'dde3389146ea5eb20a8aa79c74296b2c',
        ),
    ],

    /**
     * 微信支付配置
     */
    'wxPay' => [
        'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
        'app_id' => 'wxe463a91a2c940984', // 公众号 APPID
        'miniapp_id' => 'wx58d6104ff75296e9', // 小程序 APPID
        'mch_id' => '1602996456',
        'key' => 'Qinglianfangzhou5000AAAAAAAAAAAA',
        'notify_url' => 'https://g.5000aaa.com/notify/1',//默认回调地址
        'cert_client' => env('ROOT_PATH').'public/cert/qlfz/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => env('ROOT_PATH').'public/cert/qlfz/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => env('runtime_path').'logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'normal', // normal-正常模式，dev-沙盒模式
    ],
];
