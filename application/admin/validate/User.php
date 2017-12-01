<?php
namespace app\admin\validate;
use think\Validate;

class User extends Validate
{

    protected $rule = [
            'name|用户名' => 'require|min:5|max:20|token',
            'password|密码' => 'require|/^(?=.*[0-9].*)(?=.*[A-Z].*)(?=.*[a-z].*).\w{7,17}$/',
            'verify|验证码'=>'require|captcha',
            'new_password|新密码' => 'require|different:password|/^(?=.*[0-9].*)(?=.*[A-Z].*)(?=.*[a-z].*).\w{7,17}$/',
            'new_password1|新密码' => 'require|confirm:new_password',
    ];

    protected $message = [
            'name.require' => '用户名不能为空',
            'name.min' => '用户名最小不能低于5个字符',
            'name.max' => '用户名最多不能超过20个字符',
            'password.require' => '密码不能为空'
    ];
    
    protected $scene = [
            'user'  =>  ['name','password'],
            'login' =>  ['name','password','verify'],
            'edit'  =>  ['new_password','new_password1']
    ];
    
}