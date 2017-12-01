<?php
/**
 * 多级控制器
 * http://www.think.com/index/one.test/first
 */
namespace app\index\controller\one;
use think\Route;

class Test extends \think\Controller
{

    public function _initialize()
    {
        parent::_initialize();
        Route::bind('index/one.blog');
    }
    public function getIndex()
    {
        return 'Index';
    }
   
    public function getInfo()
    {
        return 'Info';
    } 
    
}
