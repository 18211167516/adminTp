<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

/**
 * 数据库管理
 * @author baibai
 *
 */
class Dboperate extends Controller
{
    /**
     * 数据库列表
     * @access list
     * @return \think\Response
     */
    public function index()
    {
        $db_name = config("database.database");
        $res = Db::connect('db_config1')->table('TABLES')->where('TABLE_SCHEMA',$db_name)->paginate(10)->each(function($item, $key){
            $item['DATA_LENGTH'] = calc($item['DATA_LENGTH']);
            $item['INDEX_LENGTH'] = calc($item['INDEX_LENGTH']);
            return $item;
        });
        $this->assign('list',$res);
        return $this->fetch('index');
    }
    
    /**
     * 数据库操作
     * @access list
     */
    public function operate()
    {
        return $this->fetch();
    }
    
    /**
     * 数据库fetch操作
     * @access fetch
     */
    public function fetch_sql()
    {
        if($this->request->isPost())
        {
            $sql = input('post.sql','');
            if(!$sql)
            {
                $this->error('参数错误');
            }
            $sql = htmlentities(trim($sql,' '));
            $res = Db::query($sql);
            dump($sql);dump($res);exit;
        }
    }
    
    /**
     * 数据库query操作
     */
    public function query_sql()
    {
     if($this->request->isPost())
        {
            $sql = input('post.sql','');
            if(!$sql)
            {
                $this->error('参数错误');
            }
            $sql = htmlentities(trim($sql,' '));
            $res = Db::execute($sql);
            dump($sql);dump($res);exit;
        }
    }
    
    /**
     * 清空数据库
     */
    public function truncate()
    {
        if($this->request->isAjax())
        {
            $table_name = input('get.name','');
            if(!$table_name)
            {
                return json(array('msg'=>'参数错误','url'=>'/admin/dboperate/index'), 500);
            }
            
            Db::execute("truncate {$table_name}");
            return json(array('msg'=>'清空成功','url'=>'/admin/dboperate/index'), 200);
            
        }
        else
        {
            return json(array('msg'=>'非法访问','url'=>'/admin/dboperate/index'), 501);
        }
          
    }
    
    /**
     * 查看表结构
     * @access get
     */
    public function table_desc()
    {
        $table_name = input('get.name','');
        if(!$table_name)
        {
            $this->error('参数错误','admin/dboperate/index');
        }
        
        $db_name = config("database.database");
        $res = Db::connect('db_config1')->query("SELECT COLUMN_NAME,COLUMN_TYPE,DATA_TYPE,CHARACTER_MAXIMUM_LENGTH,COLUMN_COMMENT,IS_NULLABLE,COLUMN_KEY
        FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '{$db_name}' AND TABLE_NAME = '{$table_name}'");
        $this->assign('list',$res);
        return $this->fetch('desc');
    }
}
