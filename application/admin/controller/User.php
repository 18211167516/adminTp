<?php

namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\User as UserModel;
/**
 * 管理员管理
 * @author baibai
 *
 */
class User extends Common
{
    /**
     * 管理员列表
     * @access list
     * @return \think\Response
     */
    public function index()
    {
       $name = input('get.name','');
       if($name)
       {
           $list = UserModel::where('name',$name)->order('status asc,id desc')->paginate(10);
       }
       else 
       {
           $list = UserModel::order('status asc,id desc')->paginate(10);
       }
       $this->assign('list',$list);
       return $this->fetch();
    }
    
    /**
     * 添加管理员
     * @access add
     * @param UserModel $UserModel
     * @return mixed
     */
    public function add(UserModel $UserModel)
    {
        if($this->request->isPost())
        {
            $data = $this->request->param();
            $validate = validate('User');
            if (! $validate->scene('user')->check($data)) {
                $this->error($validate->getError(),'/admin/user/index');
            } else {
                $res =  $UserModel->allowField(true)->save($data);
                if($res)
                {
                    $this->success('添加成功','/admin/user/index');
                }
                else 
                {
                    $this->error('添加失败','/admin/user/index');
                }
                
            } 
        }
       
        return $this->fetch('user_form');
    }
    
    /**
     * 删除管理员
     * @access del
     * @return \think\response\Json
     */
    public function del()
    {
      if($this->request->isAjax())
      {
          $id = input('get.id');
          $user = UserModel::get($id);
          if(!$user)
          {
              return json(array('msg'=>'参数错误，没有该管理员','url'=>'/admin/user/index'),500);
          }
          else
          {
              $res = $user->delete();
              if($res)
              {
                  return json(array('msg'=>'删除成功','url'=>'/admin/user/index'), 200);
              }
              else 
              {
                  return json(array('msg'=>'删除失败','url'=>'/admin/user/index'), 500);
              }
          }  
      }
    }
    
    /**
     * 停用/启用管理员
     * @access edit
     * @return \think\response\Json
     */
    public function stop()
    {
        if($this->request->isAjax())
        {
            $id = input('get.id');
            $user = UserModel::get($id);
            if(!$user)
            {
                return json(array('msg'=>'参数错误，没有该管理员','url'=>'/admin/user/index'),500);
            }
            else
            {
                $data['status'] = input('get.status');
                $data['id']     = $id;
                switch($data['status'])
                {
                    case '1':
                    $msg = '启用';
                    break;
                    case '2':
                    $msg = '停用';
                    break;
                }
                $res = $user->update($data);
                if($res)
                {
                    return json(array('msg'=>$msg.'成功','url'=>'/admin/user/index'), 200);
                }
                else
                {
                    return json(array('msg'=>$msg.'失败','url'=>'/admin/user/index'), 500);
                }
            }
        }
    }
    /**
     * 修改密码
     * @access edit
     * @return mixed
     */
    public function edit_password()
    {
        if($this->request->isPost())
        {
            $id   = input('get.id');
            $user = UserModel::get($id);
            $data = $this->request->post();
            $validate = validate('User');
            if (! $validate->scene('edit')->check($data)) 
            {
                $this->error($validate->getError(),'/admin/user/edit_password?id='.$id);
            }
            else 
            {
                $res = $user->update(array('id'=>$id,'password'=>$data['new_password']));
                if($res)
                {
                    $this->success('修改密码成功','/admin/user/index');
                }
                else 
                {
                    $this->error('修改密码失败！','/admin/user/index');
                }
            }
             
        }
       
        return $this->fetch('pwd_form');
    }
    
    /**
     * 分配角色
     * @access add
     * @param UserModel $UserModel
     */
    public function role_assign(UserModel $UserModel)
    {
       $id = input('get.id');
       if($this->request->isPost())
       {
           $data['rule'] = $this->request->only('rule');
           $data['id'] = $id;
           $res = $UserModel->update($data);
           if($res)
           {
               $this->success('分配角色成功','/admin/user/index');
           }
           else
           {
               $this->error('分配角色失败','/admin/user/index');
           }
       }
       $user = $UserModel->get($id);
       if(!$user)
       {
          $this->error('参数错误，该管理员不存在！');
       }
       
       $role_list  = $UserModel->roleList();
       
       $this->assign('role_list',$role_list);
       $this->assign('rule',explode(',',$user->getData('rule')));
       return $this->fetch();
    }
    

}
