<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------
namespace tests;

class IndexTest extends \think\testing\TestCase
{
    protected $baseUrl = 'http://www.think.com';
    public function testFirst()
    {
        //visit 发起get请求
        //see  正则匹配返回结果
        $this->visit('/index/index/test')->see('phpunit 测试');
    }
}