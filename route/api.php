<?php

declare(strict_types=1);

/**
 * @class
 * @auth echo
 * @email 945462788@qq.com
 * @github https://github.com/945462788
 **/
use think\facade\Route;

//Route::group('api/',function (){
//
//})->middleware();

Route::post('wechat/app-login','api.Auth/weChatAppLogin');

