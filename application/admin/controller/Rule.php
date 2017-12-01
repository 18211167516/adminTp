<?php

namespace app\admin\controller;

use app\admin\model\Rule as Rules;
use docParser\DocParser;
/**
 * 角色管理
 * @author baibai
 *
 */
class Rule extends Common
{
    
    /**
     * 分配权限
     * @access edit
     * @param DocParser $doc
     * @return mixed
     */
    public function rule_assign(Rules $rule)
    {
        //
        if($this->request->isPost())
        {
            $id = input('get.id');
            if(!$id)
            {
                $this->error('参数错误','/admin/rule/rule_list');
            }
        
            $role = $rule->get($id);
            if(!$role)
            {
                $this->error('此类角色不存在，不能分配权限','/admin/rule/rule_list');
            }
        
            $data['rule_rights'] = $this->request->only('rule_rights');
            $data['id'] = $id;
            $res = $rule->update($data);
            if($res)
            {
                $this->success('分配权限成功','/admin/rule/rule_list');
            }
            else
            {
                $this->error('分配权限失败','/admin/rule/rule_list');
            }
        }
        $id = input('get.id');
        $menu_list = $rule->getAllClass(new DocParser());
        $rule_info = $rule->get($id);
        $this->assign('menu_list',$menu_list);
        $this->assign('rule_rights',$rule_info->rule_rights);
        $this->assign('id',$id);
        return $this->fetch('rule_assign');
    }
    
    /**
     * 角色列表
     * @access list
     * @param Rules $rule
     * @return mixed
     */
    public function rule_list(Rules $rule)
    {
       $rule_name = input('get.rule_name','');
       if($rule_name)
       {
           $list = $rule->where('rule_name',$rule_name)->where('status', 1)->whereor('status',2)->order('id','desc')->paginate(10);
       }
       else
       {
           $list = $rule->where('status', 1)->whereor('status',2)->order('id','desc')->paginate(10);
       }
       
       $this->assign('list',$list);
       return $this->fetch();    
    }
    
    /**
     * 角色添加
     * @access add
     * @param Rules $rule
     */
    
    public function rule_add(Rules $rule)
    {
       if($this->request->isPost())
       {
           $data['rule_name'] = input('post.rule_name');
           $data['rule_desc'] = input('post.rule_desc');
           $res = $rule->save($data);
           if($res)
           {
               $this->success('添加角色成功','/admin/rule/rule_list');
           }
           else 
           {
               $this->error('添加角色失败','/admin/rule/rule_list');   
           }
       }
       else
       {
           return $this->fetch('rule_form');
       }
        
    }
    
    /**
     * 角色编辑
     * @access edit
     * @param Rules $rule
     */
    
    public function rule_edit(Rules $rule)
    {
        $id = input('get.id');
        if($this->request->isPost())
        {
            
            $data['rule_name'] = input('post.rule_name');
            $data['rule_desc'] = input('post.rule_desc');
            $res = $rule->save($data,['id'=>$id]);
            if($res)
            {
                $this->success('编辑角色成功','/admin/rule/rule_list');
            }
            else
            {
                $this->error('编辑角色失败','/admin/rule/rule_list');
            }
        }
        else
        {
            $info = $rule->get($id);
            $this->assign('info',$info);
            return $this->fetch('rule_form');
        }
    
    }
    
   /**
    * 角色删除
    * @access del
    * @param Rules $rule
    */
    
   public function del(Rules $rule)
    {
      if($this->request->isAjax())
      {
          $id = input('get.id');
          $rule = $rule->get($id);
          if(!$rule)
          {
              return json(array('msg'=>'参数错误，没有该角色','url'=>'/admin/rule/rule_list'),500);
          }
          else
          {
              $res = $rule->delete();
              if($res)
              {
                  return json(array('msg'=>'删除成功','url'=>'/admin/rule/rule_list'), 200);
              }
              else 
              {
                  return json(array('msg'=>'删除失败','url'=>'/admin/rule/rule_list'), 500);
              }
          }  
      }
    }
    
}
