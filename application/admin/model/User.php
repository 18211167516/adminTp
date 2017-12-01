<?php

namespace app\admin\model;

use think\Model;
use think\Cookie;
use app\admin\model\Rule;
class User extends Model
{
    // 支持给字段设置类型自动转换，会在写入和读取的时候自动进行类型转换处理
    protected $type = [
            'update_time' => 'timestamp',
            'create_time' => 'timestamp'
    ];
    
    protected function initialize ()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
        // TODO:自定义的初始化
    }
    
    
    /**
     * status的获取器
     * @param unknown $value
     * @param unknown $data
     */
    public function getStatusAttr ($value, $data)
    {
        $status = [
                1 => '正常',
                2 => '停用',
        ];
        return $status[$data['status']];
    }
    
    /**
     * rule的获取器
     * @param unknown $value
     * @param unknown $data
     * @return unknown
     */
    public function getRuleAttr($value,$data)
    {
        //dump($data);exit;
        if($data['rule'])
        {
            $list = Rule::all($data['rule']);
            $rule = '';
            foreach($list as $rules){
                $rule .= $rules->rule_name.',';
            }
            return chop($rule,',');
        }
    }
    /**
     * 角色修改器
     * @param unknown $value
     */
    public function setRuleattr($value)
    {
        if(!empty($value))
        {
            return implode(",",$value['rule']);
        }
        else 
        {
            return '';
        }
    }
    /**
     * 密码修改器
     * @param unknown $value
     */
    public function setPasswordAttr($value)
    {
       return password_hash($value, PASSWORD_DEFAULT);
    }
    
    public function roleList()
    {
       return Rule::all()->toArray();
    }
    
    /**
     * 检测登录
     * @return boolean
     */
    public function checkLogin()
    {
        if(Cookie::has('sigcode'))
        {
            if(Cookie::get('sigcode') == $this->_set_signcode(Cookie::get('uid'), Cookie::get('uname')))
            {
                $user = $this->get(Cookie::get('uid'));
                if($user)
                {
                    return $user->getData();
                } 
                return false;
            }
            return false;
           
        }
        else 
        {
            return false;
        }
        
    }
    
    public function getRole($id)
    {
       $role = $this->get($id);
       if(!$role)
       {
           throw new \think\Exception('管理员异常', 100006);
       }
       $list = Rule::all($role->getData('rule'))->toArray();
       if(empty($list))
       {
           throw new \think\Exception('该用户未分配角色，请联系超级管理员', 100007);
       }
       $role = array();
       $method_list = array_column($list, 'rule_rights');
       foreach ($method_list as $k=>$v)
       {
           foreach ($v as $value)
           {
               array_push($role,$value);
           }
       }
       return array_unique($role);
    }
    
    /**
     * 登录
     * @param unknown $data
     * @return multitype:string
     */
    public function login($data)
    {
        $return = array('msg'=>'登录成功','url'=>'/admin/index'); 
        $user = $this->get(['name'=>$data['name']]);
        if(!$user)
        {
            $return['msg'] = '用户名不存在';
            $return['url']  = '';
        }
        if(!password_verify($data['password'],$user->password))
        {
            $return['msg'] = '密码不正确，请重新输入';
            $return['url']  = '';
        }
        Cookie::set('uid',$user->getAttr('id'),3600);
        Cookie::set('uname',$user->getAttr('name'),3600);
        Cookie::set('sigcode',$this->_set_signcode($user->getAttr('id'),$user->getAttr('name')),3600);
        
        return $return;
    }
    /**
     * 登录加密
     * @param unknown $user_id
     * @param unknown $user_name
     */
    private function _set_signcode($user_id,$user_name)
    {
        return MD5($user_id.$user_name.SIGN_SUFFIX);
    }
    
    /**
     * 退出登录
     * @return boolean
     */
    public function logout()
    {
        Cookie::clear('tp_');
        return true;
    }
}
