<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
use think\facade\Route;
use app\common\middleware\TokenMiddleware;

Route::group('api/',function (){

    //需要登录
    Route::group(function (){

        //用户
        Route::group('user/',function (){
            Route::get('info','getUserInfo');
        })->prefix('api.user.User/');

    })->middleware(TokenMiddleware::class);

    //不需要登录
    Route::group(function (){
        Route::post('wechat/app_login','api.Auth/weChatAppLogin');
        Route::post('wechat/login','api.Auth/weChatLogin');
        Route::group('resources/',function (){
            Route::get('wechat_js_sdk','WeChatJsSdkConfig');
            Route::get('token','getToken');
        })->prefix('api.Resources/');
    });

})->middleware(\app\common\middleware\AllowOriginMiddleware::class);



