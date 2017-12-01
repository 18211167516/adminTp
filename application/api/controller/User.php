<?php
/**
 * api用户接口
 */
namespace app\api\controller;

use \app\api\model\User as Users;
use app\api\model\UserExt;
use think\captcha\Captcha;
class User extends Common
{

    public $Model_user;

    public function _initialize ()
    {
        parent::_initialize();
        $this->Model_user = new Users();
    }

    public function index ($id)
    {
        return '用户' . $id;
    }

    public function login2 ()
    {
        //获取id为9的数据
        $user = $this->Model_user->get(9);
        //添加数据表中为定义的字段
        $user->append(['status_text']);
        return $user;
        exit();
        return '登录';
    }
    
    public function login()
    {
        $validate = validate('User');
        $captcha = new Captcha();
        echo $captcha->entry();
    }
    
    public function getAll()
    {
        $user = $this->Model_user->all();
        dump($user->toArray());
        dump($user->toJson());exit;
    }
    
    public function test()
    {
      //聚合
      echo $this->Model_user->count();
      //
      $user = $this->Model_user->get(8);
      echo $user->status;
      echo $user->status_text;
      dump($user->toArray());//获取全部获取器数据
      dump($user->getData());//获取全部原始数据
    }
    
    /**
     * 更新数据
     */
    public function update()
    {
       $user = $this->Model_user->get(9);
       if($user)
       {
           $user->name = 'bai';
           return $user->save();
       }
       else
       {
           return '更新的数据不存在';
       }
       
    }
    
    public function del()
    {
        
        dump($this->Model_user->onlyTrashed()->select());exit;
        $user = $this->Model_user->get(10);
        if($user)
        {
            return $user->delete();
            
        }
        else 
        {
            return '该数据已被删除';
        }
        
    }
    
    public function relation()
    {
        $user = $this->Model_user->get(2);
        return $user->profile;exit;
        $Userext = UserExt::get(1);
        return $Userext->user;exit;
        //关联更新
        return $user->profile->save(['email' => 'thinkphp2']);exit;
        //关联新增
        $user->profile()->save(['email' => 'thinkphp2']);
        
        
        return $user->id;
    }
    
    /**
     * 注册
     */
    public function register ()
    {
        /* $data = $this->request->except('time,token');
        return $this->Model_user->save($data); */
        $data = $this->request->param();
        $this->Model_user->allowField(true)->save($data);
        //返回自增id
        return $this->Model_user->id;
    }
    
    /**
     * 退出
     */
    public function logout()
    {
        echo '退出登录';
    }
}