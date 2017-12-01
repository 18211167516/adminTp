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
Route::rule('login', 'user/login', 'POST|GET');
Route::rule('register', 'user/register', 'POST|GET');
Route::rule('logout', 'user/logout', 'POST|GET');
Route::rule('test/[:id]', 'user/test', 'POST|GET');
Route::rule('update', 'user/update', 'POST|GET');
Route::rule('del', 'user/del', 'POST|GET');
Route::rule('all', 'user/getAll', 'POST|GET');
Route::rule('relation', 'user/relation', 'POST|GET');

//api.think.com/json/images.json => www.think.com/api/image/images
Route::rule('json/images.json','image/images','POST|GET');
Route::rule('json/newsList.json','news/index','POST|GET');
Route::rule('json/usersList.json','users/index','POST|GET');
Route::rule('json/message.json','message/index','POST|GET');
Route::rule('json/systemParameter.json','system/index','POST|GET');

// http://www.think.com/test/info http://www.think.com/index/one.index/info 快捷路由
Route::controller('test', 'index/one.test');

// http://www.think.com/a/index http://www.think.com/index/index/index 路由别名
Route::alias('a', 'index/index');

// 路由闭包
Route::get('hello/:name', 
        function  ($name = 123)
        {
            return redirect('index/index');
        });
//绑定路由 http://www.think.com/index/index/read
//Route::bind('index');
//Route::bind('index/bind');
//Route::bind('index/bind/read');

