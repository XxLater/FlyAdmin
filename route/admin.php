<?php

/**
 * @author echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
use think\facade\Route;
use app\common\middleware\AdminMiddleware;
use app\common\middleware\AllowOriginMiddleware;
Route::group('admin/',function (){

    /**
     * 需要登录
     */
    Route::group(function (){

        //首页
        Route::group('index/',function (){
            Route::get('index','Index');
            Route::get('console','console');
        })->prefix('admin.Index/');
        //用户
        Route::group('user/',function (){
           Route::any('info','getUserInfo');
        })->prefix('admin.user.User/');

        //菜单
        Route::group('system/menu',function (){
            Route::get('auth_menu','getAuthMenu');
        })->prefix('admin.system.Menu/');
    })->middleware(AdminMiddleware::class);

    /**
     * 不需要登录
     */
    Route::group(function (){
        Route::any('/','admin.Auth/Login');
    });


})->middleware(AllowOriginMiddleware::class);


Route::any('/','Index/Index');