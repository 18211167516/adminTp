<?php
/**
 * 控制器前置操作
 */
namespace app\index\controller;
use think\Route;

class Index extends \think\Controller
{

    protected $beforeActionList = [
            'first' => ['except'=>'test'],
            'second' => [
                    'except' => 'hello,test'
            ], // 表示这些方法不使用前置方法
            'three' => [
                    'only' => 'data',
                    'except'=> 'test'
            ]
    ] // 表示只有这些方法使用前置方法
;

    public function _initialize ()
    {
        parent::_initialize();
        //Route::bind('index/index');
    }

    public function Index ()
    {
        return $this->fetch();
    }

    public function test()
    {
        return 'phpunit 测试';
        echo 'phpunit 测试';
    }
    public function first ()
    {
        echo 'first<br/>';
    }

    public function second ()
    {
        echo 'second<br/>';
    }

    public function three ()
    {
        echo 'three<br/>';
    }

    public function hello ()
    {
        return 'hello';
    }

    public function data ()
    {
        return 'data';
    }
}
