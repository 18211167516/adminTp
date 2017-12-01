<?php
/**
 * api公共controller
 *
 * @author baibai
 *
 */
namespace app\api\controller;
use think\Request;

class Common extends \think\Controller
{

    protected $request;
    protected $beforeActionList = [
            'check_passwd'=>['only'=>'login'],
    ];
    
    // 构造函数
    public function _initialize ()
    {
        parent::_initialize();
        $this->request = Request::instance();
        $this->check_time($this->request->request('time', ''));
        $this->check_token($this->request->param());
    }

    /**
     * 检测时间参数
     *
     * @param unknown $time            
     */
    public function check_time ($time)
    {
        if (intval($time) <= 1) {
            $this->return_msg(400, '时间戳不正确');
        }
        if (time() - $time > 60) {
            $this->return_msg(401, '请求超时');
        }
    }
    
    /**
     * 检测token
     * 
     * @param unknown $arr
     */
    public function check_token ($arr)
    {
        if (! isset($arr['token']) || empty($arr['token'])) {
            $this->return_msg('400', 'token不存在！');
        }
        
        $app_token = $arr['token'];
        // 服务端token
        unset($arr['token']);
        $server_token = '';
        foreach ($arr as $k => $v) {
            $server_token .= md5($v);
        }
        $server_token = md5('api_' . $server_token);
        if ($server_token !== $app_token) {
            $this->return_msg('400', 'token检测错误！');
        }
    }
    
    public function check_passwd()
    {
        echo '检测密码';
    }

    /**
     * 返回json数据
     *
     * @param string $code            
     * @param string $msg            
     * @param unknown $data            
     */
    public function return_msg ($code = '200', $msg = '', $data = [])
    {
        $arr['code'] = $code;
        $arr['msg'] = $msg;
        $arr['data'] = $data;
        echo json_encode($arr);
        die();
    }
}