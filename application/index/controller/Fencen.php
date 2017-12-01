<?php

/**
 * 分层控制器
 * 1.需要在index下建event目录
 * 2.建class
 * namespace app\index\event;

    class Blog 
    {
       public function add()
       {
           return '分层控制器add';
       }
    }
 */
namespace app\index\controller;

class Fencen
{
    public function index()
    {
        $event = controller('Blog','event');
        return $event->add();
    }
    
    /**
     * 直接调用分层控制器类的某个方法
     * @return mixed
     */
    public function test()
    {
        
        //return  \think\Loader::action('Blog/test', [], 'event');
        return action('Blog/test',[],'event');
    }
}