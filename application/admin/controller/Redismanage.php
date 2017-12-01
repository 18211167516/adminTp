<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\cache\driver\Redis;
use think\Model;
/**
 * redis管理工具
 * @author baibai
 *
 */
class Redismanage extends Controller
{
    /**
     * 服务器信息
     * @access list
     * @return \think\Response
     */
    public function index()
    {
        //
        $redis = new Redis();
        $res = $redis->info();
        $desc = Config('desc');
        $this->assign('desc',$desc);
        $this->assign('info',$res);
        return $this->fetch();
    }
    
    /**
     * redis搜索
     * @access list
     */
    public function search()
    {
        
        $redis = new Redis();
        $key   = input('post.key','');
        $type = $redis->type($key);
        $info = ['key'=>$key];
        switch($type)
        {
            case 1:
                //string
                $info['value'] = $redis->get($key); 
            break;
            case 2:
                //set
                $info['value'] = $redis->Smembers($key);
            break;
            case 3:
                //list
                $info['value'] = $redis->Lrange($key,0,-1);
            break;   
            case 4:
                //zset
                $info['value'] = $redis->Zrange($key,0,-1);
            break;
            case 5:
                //hash
                $info['value'] = $redis->hGetall($key);
            break;
        }
        $this->assign('type',$type);
        $this->assign('list',$info);
        return $this->fetch();
    }

}
