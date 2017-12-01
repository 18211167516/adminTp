<?php

namespace  app\Common\behavior;
use think\Controller;
use think\Cookie;
use app\admin\model\User;
use think\Request;
use think\Config;
/**
 * 权限检测
 * @author baibai
 *
 */
class CheckAuth extends Controller
{
   public function run(&$params)
   {
       Config::load(APP_PATH.'Common/config.php');
       $user = new User();
       $dispatch['module'] = request()->module();
       $dispatch['controller'] = request()->controller();
       $dispatch['action'] = request()->action();
       $filter_arr = Config('filter_arr');
       $route = Config('role_file');
       if(!empty($filter_arr))
       {
           foreach ($filter_arr as $k=>$v)
           {
               if(!isset($route[$dispatch['module']]))
               {
                    break;
               }
               if($k == $dispatch['module'] && in_array($dispatch['controller'],$v))
               {
                    break;
               }
               else 
               {
                    if(!$user->checkLogin())
                    {
                        if(strtolower($dispatch['controller']) != 'login')
                        {
                            $this->redirect('/admin/login',302);
                        }
                    }
                    try
                    {
                        $role = $user->getRole(Cookie::get('uid'));
                        if(!in_array((implode('/', $dispatch)),$role))
                        {
                          throw new \think\Exception('当前模块没有权限！', 100008);  
                        }
                    }
                    catch(\think\Exception $e)
                    {
                        if($e->getCode() == 100007)
                        {
                            $this->error($e->getMessage(),'/admin/login/logout');
                        }
                        $this->error($e->getMessage());
                    }
                    
               }
           } 
       }
       
   }
}