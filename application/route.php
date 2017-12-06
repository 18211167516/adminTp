<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;


Route::rule('admin/login','admin/login/login');
Route::rule('admin/logout','admin/login/logout');
Route::rule('admin/captcha','admin/login/captcha');
Route::rule('admin/main','admin/index/main');

// api.think.com => www.think.com/api 'url_domain_deploy' => true 域名绑定
Route::domain('api', 'api');
// api.think.com/user/2 => www.think.com/api/user/index/id/2
//Route::rule('user/:id', 'user/index');

// api.think.com/login => www.think.com/api/user/login
