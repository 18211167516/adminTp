<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\captcha\Captcha;
use app\admin\model\User;
use think\Model;
/**
 * 后台登陆
 * @author baibai
 *
 */
class Login extends Common
{

    /**
     * 登录
     * @return \think\Response
     */
    public function login ()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->param();
            $validate = validate('User');
            if (! $validate->scene('login')->check($data)) {
                $return['msg'] = $validate->getError();
                $return['url'] = '';
            } else {
                $user = new User();
                $return = $user->login($data);
            }
            return json($return, 200);
        }
        return $this->fetch();
    }
    /**
     * 验证码
     */
    public function captcha ()
    {
        $config = [
                // 验证码字体大小
                'fontSize' => 20,
                // 验证码位数
                'length' => 4,
                // 关闭验证码杂点
                'useNoise' => false,
                'useCurve' => false
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
    
    /**
     * 退出登录
     * @param User $user
     */
    public function logout(User $user)
    {
        
        if($user->logout())
        {
            $this->success('退出登录成功！', '/admin/login');
        }
    }
}
