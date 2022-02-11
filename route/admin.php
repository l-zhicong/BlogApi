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
use app\common\middleware\AllowOriginMiddleware;
use app\common\middleware\AuthTokenMiddleware;
use think\facade\Route;


Route::group('adminapi',function (){
    /*public*/
    Route::group(function () {
        //用户名密码登录
        Route::post('login', 'Login/login')->name('AdminLogin');
        Route::post('logout','Login/logout');
//        //后台登录页面数据
//        Route::get('login/info', 'Login/info')->option(['real_name' => '登录信息']);
        //验证码
        Route::get('captcha_pro', 'Login/captcha')->name('')->option(['real_name' => '获取验证码']);
        Route::get('index', 'Test/index')->option(['real_name' => '测试地址']);
    })->middleware(AllowOriginMiddleware::class);

    /*private*/
    Route::group(function(){
        Route::group("user",function (){
            Route::Post('info','v1.User/getInfo');
        });

        //管理员
        Route::group('system',function(){
            Route::post('lst','/Admin/getList')->alias('systemLst');
            Route::post('create','/Admin/create')->alias('systemCreate');
            Route::get('update/:id','/Admin/update')->alias('systemUpdateForm');
            Route::post('update/:id','/Admin/update')->alias('systemUpdate');
            Route::post('password/:id','/Admin/password')->alias('systemPassword');
            Route::post('delete/:id','/Admin/delete')->alias('systemDelete');
            Route::post('status/:id','/Admin/updateStatus')->alias('systemStatus');
            Route::post('roleForm','/Admin/roleForm')->alias('systemRoleForm');
            Route::get('log', '/AdminLog/lst')->alias('systemAdminLog');
        });

        //权限管理
        Route::group('menu',function(){
            Route::post('lst','/Menu/getList')->alias('menuLst');
            Route::post('create','/Menu/create')->alias('menuCreate');
            Route::get('create/form','/Menu/createForm')->alias('menuCreateForm');
            Route::get('update/:id','/Menu/update')->alias('menuUpdateForm');
            Route::post('update/:id','/Menu/update')->alias('menuUpdate');
            Route::post('delete/:id','/Menu/delete')->alias('menuDelete');
        });
        Route::post('menus','/Menu/menus');

        //身份管理
        Route::group('role',function(){
            Route::post('lst','/Role/getList')->alias('roleLst');
            Route::post('create','/Role/create')->alias('roleCreate');
            Route::get('create/form','/Role/createForm')->alias('roleCreateForm');
            Route::get('update/:id','/Role/update')->alias('roleUpdateForm');
            Route::post('update/:id','/Role/update')->alias('roleUpdate');
            Route::post('delete/:id','/Role/delete')->alias('roleDelete');
            Route::post('status/:id','/Role/updateStatus')->alias('roleStatus');
        });

        //用户管理
        Route::group('user',function(){
            Route::post('lst','/User/list')->alias('userLst');
            Route::post('status/:id','/User/statusUpdate')->alias('userStatus');
            Route::post('details/:id','/User/details')->alias('userDetails');
            Route::post('info','/User/info');
            Route::get('recruiterLst','/User/getRecruiterList')->alias('userRecruiterList');
            Route::get('getListByName','/User/getIdListByName')->alias('userListByName');
            Route::get('userExtractRecord','/User/userExtractRecord')->alias('userExtractRecord');
            Route::post('extractStatus/:id','/User/extractStatus')->alias('userExtractStatus');
        });

    })->middleware(AuthTokenMiddleware::class)->middleware(AllowOriginMiddleware::class);


})->prefix('admin.');
