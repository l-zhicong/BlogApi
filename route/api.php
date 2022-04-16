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

Route::group('api',function (){
    /*public*/
    Route::group(function () {
        Route::group("article",function (){
            Route::get("list",'Article/getList');
            Route::get("info/:id",'Article/getInfo');
            Route::group("category",function (){
                Route::get('list','ArticleCategory/getList');
            });
        });
    })->middleware(AllowOriginMiddleware::class);

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
})->prefix('api.V1.');