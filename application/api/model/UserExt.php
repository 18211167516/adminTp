<?php

namespace app\api\model;

use think\Model;

class UserExt extends Model
{
    protected $type = [
            'update_time' => 'timestamp',
            'create_time' => 'timestamp'
    ];
    protected function initialize ()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
        // TODO:自定义的初始化
    }
    
    public function user()
    {
        return $this->belongsTo('User');
    }
}
