<?php


namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;

class Common extends Controller
{
    protected $request;
    protected function _initialize()
    {
        parent::_initialize();
        $this->request = request();
        $user = new User();
        if(!$user->checkLogin())
        {
            if(strtolower($this->request->controller()) != 'login')
            {
                $this->redirect('/admin/login',302);
            }
        }
        $this->assign('current_url',$this->request->url());
    }
    
    
}