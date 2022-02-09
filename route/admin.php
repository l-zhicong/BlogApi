<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


Route::group('adminapi',function (){
    Route::group(function () {
        //用户名密码登录
        Route::post('login', 'Login/login')->name('AdminLogin');
//        //后台登录页面数据
//        Route::get('login/info', 'Login/info')->option(['real_name' => '登录信息']);
//        //下载文件
//        Route::get('download', 'PublicController/download')->option(['real_name' => '下载文件']);
//        //验证码
        Route::get('captcha_pro', 'Login/captcha')->name('')->option(['real_name' => '获取验证码']);
//
//
//        Route::get('index', 'Test/index')->option(['real_name' => '测试地址']);

    });


})->prefix('admin.');
