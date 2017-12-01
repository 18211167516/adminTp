<?php

namespace app\admin\model;

use think\Model;
use think\Cache;

class Rule extends Model
{
    protected $update = [
            'update_time'
    ];
    // 支持给字段设置类型自动转换，会在写入和读取的时候自动进行类型转换处理
    protected $type = [
            'update_time' => 'timestamp',
            'create_time' => 'timestamp'
    ];
    
    protected $filter_arr;
    
    // 设置模型的数据集返回类型
    protected $resultSetType = 'collection';

    protected function initialize ()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
        if(empty($this->filter_arr))
        {
            $this->filter_arr = Config('filter_arr');
        }
        // TODO:自定义的初始化
    }

    /**
     */
    protected static function init ()
    {
       
    }

    /**
     * 获取器
     * @param unknown $value            
     * @param unknown $data            
     */
    public function getStatusAttr ($value, $data)
    {
        $status = [
                1 => '正常',
                2 => '停用',
                3 => '删除',
        ];
        return $status[$data['status']];
    }
    
    public function setRuleRightsAttr($value)
    {
        if(!empty($value))
        {
            return implode(",",$value['rule_rights']);
        }
        else 
        {
            return '';
        }
    }
    
    public function getRuleRightsAttr($value)
    {
        if(!empty($value))
        {
            return explode(',',$value);
        }
        else 
        {
            return array();
        }
    }
    
    /**
     * 获取控制器以及方法、注释
     * @param unknown $doc
     * @param string $type
     */
    public function getAllClass($doc,$type='')
    {
            $menu_list = Cache::get('menu_list'.$type);
            if($menu_list && Config('app_debug') === false)
            {
                return $menu_list;
            }
            foreach (Config('role_file') as $k=> $v)
            {
                if(!file_exists($v))
                {
                    continue;
                }
                $file=scandir($v);
                unset($file[0]);unset($file[1]);unset($file[2]);
                $files[$k] = $file;
            }
            $menu_list = array();
            foreach($files as $site=>$file)
            {
                foreach($file as $v)
                {
                    $className = basename($v,".php");
                    if(in_array($className, $this->filter_arr[$site])){
                        continue;
                    }
                    $c  = new \ReflectionClass(Config('app_namespace').'\\'.$site.'\\controller\\'.$className);
                     
                    $menu_list[$site.'/'.$className]['doc'] = $doc->parse($c->getDocComment());
                    $method_list = $c->getMethods( \ReflectionMethod::IS_PUBLIC);
                    if(!empty($method_list))
                    {
                        foreach($method_list as $mk=>$val)
                        {
                            if($val->isConstructor() || $val->name == '_initialize')
                            {
                                if(count($method_list) == 1)
                                {
                                    unset( $menu_list[$site.'/'.$className]);
                                }
                                unset($method_list[$mk]);
                                continue;
                            }
                            $menth_doc = $doc->parse($val->getDocComment());
                            if($type !='')
                            {
                                
                                if(!empty($menth_doc) && $menth_doc['access']!= '' && $menth_doc['access'] == $type )
                                {
                                    $menu_list[$site.'/'.$className]['method'][] = array('name'=>$site.'/'.$className.'/'.$val->name,'doc'=>$doc->parse($val->getDocComment()));
                                }
                                else 
                                {
                                    continue;
                                }
                            }
                            else 
                            {
                                $menu_list[$site.'/'.$className]['method'][] = array('name'=>$site.'/'.$className.'/'.$val->name,'doc'=>$doc->parse($val->getDocComment()));
                            }
                        }
                    }
                    
                    if(!isset($menu_list[$site.'/'.$className]['method']))
                    {
                        unset( $menu_list[$site.'/'.$className]);
                    }
                }
            }
            Cache::set('menu_list'.$type,$menu_list,86400);
            return $menu_list;
    }
    
}
