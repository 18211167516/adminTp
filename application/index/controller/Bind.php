<?php

namespace app\index\controller;

class Bind extends \think\Controller
{
    public function _initialize()
    {
        parent::_initialize();
        \think\Route::bind('\app\index\controller','namespace');
       /*  \think\Route::bind('index');
        \think\Route::bind('index/bind');
        \think\Route::bind('index/bind/read'); */
    }
    
    public function index()
    {
        return '这是绑定路由index';
    }
    
    public function read()
    {
        return '这是绑定路由read';
    }
}