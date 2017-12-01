<?php

namespace app\api\controller;

use think\Controller;
use think\Request;

class System extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
       
        //
        $data['version']  = 'v1.0.0';
        $data['author']   = 'chonghuabai';
        $data['homePage'] = 'index';
        $data['server']   = 'apache';
        $data['dataBase'] = '5.6.5';
        $data['maxUpload'] = '2MB';
        $data['userRights'] = '超管';
        if($this->request->has('callback'))
        {
            return jsonp($data,200);
        }
        else 
        {
            return json($data,200);
        }
        
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
