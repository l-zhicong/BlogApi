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
use app\common\middleware\AdminTokenMiddleware;
use think\facade\Config;
use think\facade\Route;
use think\Response;

Route::group('adminapi',function (){
    /*public*/
    Route::group(function () {
        Route::post('Picture/upload', 'v1.Picture/upload');//上传图片
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
            Route::get('lst', 'v1.Admin/getList')->alias('systemLst');
            Route::post('create','v1.Admin/create')->alias('systemCreate');
            Route::get('info/:id','v1.Admin/update')->alias('systemUpdateForm');
            Route::post('update/:id','v1.Admin/update')->alias('systemUpdate');
            Route::post('password/:id','v1.Admin/password')->alias('systemPassword');
            Route::delete('delete/:id','v1.Admin/delete')->alias('systemDelete');
            Route::post('status/:id','v1.Admin/updateStatus')->alias('systemStatus');
            Route::get('roleForm','v1.Admin/roleForm')->alias('systemRoleForm'); //身份
            Route::get('log', 'v1.AdminLog/lst')->alias('systemAdminLog');
        });

        //菜单管理
        Route::group('menu',function(){
            Route::get('getTree','v1.Menu/getList')->alias('menuLst');
            Route::get('lst','v1.Menu/menus');
            Route::post('create','v1.Menu/create')->alias('menuCreate');
            Route::get('create/form','v1.Menu/createForm')->alias('menuCreateForm');
            Route::get('update/:id','v1.Menu/update')->alias('menuUpdateForm');
            Route::post('update/:id','v1.Menu/update')->alias('menuUpdate');
            Route::delete('delete/:id','v1.Menu/delete')->alias('menuDelete');
        });

        //身份管理
        Route::group('role',function(){
            Route::get('lst','v1.Role/getList')->alias('roleLst');
            Route::post('create','v1.Role/create')->alias('roleCreate');
            Route::get('getTree','v1.Role/createForm')->alias('roleCreateForm');
            Route::get('info/:id','v1.Role/update')->alias('roleUpdateForm');
            Route::post('update/:id','v1.Role/update')->alias('roleUpdate');
            Route::delete('delete/:id','v1.Role/delete')->alias('roleDelete');
            Route::post('status/:id','v1.Role/updateStatus')->alias('roleStatus');
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

        Route::group('article', function () {
            Route::get('lst', 'v1.article.Article/getList')->name('systemArticlArticleLst');
            Route::post('create', 'v1.article.Article/ArticleCreate')->name('systemArticleArticleCreate');
            Route::post('update/:id', 'v1.article.Article/ArticleUpdate')->name('systemArticArticleleUpdate');
            Route::delete('delete/:id', 'v1.article.Article/delete')->name('systemArticArticleleDelete');
            Route::get('updateForm/:id', 'v1.article.Article/ArticleUpdate')->name('systemArticArticleleDetail');
            //文章类别管理
            Route::group('category',function(){
                Route::get('lst', 'v1.article.ArticleCategory/list')->name('systemArticleCategoryLst');
                Route::post('create', 'v1.article.ArticleCategory/create')->name('systemArticleCategoryCreate');
                Route::get('updateForm/:id', 'v1.article.ArticleCategory/update')->name('systemArticleCategoryUpdateForm');
                Route::post('update/:id', 'v1.article.ArticleCategory/update')->name('systemArticleCategoryUpdate');
                Route::post('status/:id', 'v1.article.ArticleCategory/switchStatus')->name('systemArticleCategoryStatus');
                Route::delete('delete/:id', 'v1.article.ArticleCategory/delete')->name('systemArticleCategoryDelete');
            });
        });

        Route::group('myhomepage', function () {
            Route::get('lst','v1.mydata.HomePage/getList');
            Route::post('create','v1.mydata.HomePage/create');
        });
    })->middleware([
        AllowOriginMiddleware::class,
        AdminTokenMiddleware::class
    ]);

    /**
     * miss 路由
     */
    Route::miss(function () {
        if (app()->request->isOptions()) {
            $header = Config::get('cookie.header')->option(['real_name' => '']);
            $header['Access-Control-Allow-Origin'] = app()->request->header('origin')->option(['real_name' => '']);
            return Response::create('ok')->code(200)->header($header);
        } else
            return Response::create()->code(404);
    });
})->prefix('admin.');
