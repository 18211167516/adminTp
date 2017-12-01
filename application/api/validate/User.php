<?php
namespace app\api\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
            'name'  =>  'require|max:20|chsAlpha',
            'password' =>  'email',
    ];
}