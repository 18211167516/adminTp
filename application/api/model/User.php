<?php
namespace app\api\model;
use think\Model;
use traits\model\SoftDelete;
// 用于软删除
class User extends Model
{
    use SoftDelete;
    
    // 系统支持auto、insert和update三个属性，可以分别在写入、新增和更新的时候进行字段的自动完成机制，auto属性自动完成包含新增和更新操作
    protected $auto = [
            'ip'
    ];

    protected $insert = [
            'status'
    ];

    protected $update = [
            'update_time'
    ];
    // 支持给字段设置类型自动转换，会在写入和读取的时候自动进行类型转换处理
    protected $type = [
            'update_time' => 'timestamp',
            'create_time' => 'timestamp'
    ];
    // 软删除
    protected static $deleteTime = 'delete_time';
    
    // 设置模型的数据集返回类型
    protected $resultSetType = 'collection';

    protected function initialize ()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
        // TODO:自定义的初始化
    }

    /**
     */
    protected static function init ()
    {
        // 新增数据前（修改器后）
        User::event('before_insert', 
                function  ($user)
                {
                    dump('before_insert');
                    if ($user->getData('status') == 1) {
                        $user->data('status', 2);
                    }
                });
        // 新增数据后（获取器后）
        User::event('after_insert', 
                function  ($user)
                {
                    dump('after_insert');
                    if ($user->getData('status') == 2) {
                        $user->data('status', 3);
                        $user->save();
                    }
                });
        // 更新数据前
        User::event('before_update', 
                function  ($user)
                {
                    dump('before_update');
                    if ($user->id == 1) {
                        $user->data('status', 2);
                    }
                });
        // 更新数据后
        User::event('after_update', 
                function  ($user)
                {
                    dump('after_update');
                    if ($user->getData('name') == 'BAI') {
                        $user->data('password', 'bai');
                        $user->save();
                    }
                });
        // 写入数据前
        User::event('before_write', 
                function  ($user)
                {
                    dump('before_write');
                });
        // 写入数据后
        User::event('after_write', 
                function  ($user)
                {
                    dump('after_write');
                });
        //删除数据前
        User::event('before_delete', 
                function  ($user)
                {
                    dump('before_delete');
                });
        // 删除数据后
        User::event('after_delete', 
                function  ($user)
                {
                    dump('after_delete');
                });
    }

    public function profile()
    {
        return $this->hasOne('UserExt')->bind('email','sex','user_id');
    }
    /**
     * 获取器
     *
     * @param unknown $value            
     * @return Ambigous <string>
     */
    public function getStatusAttr ($value)
    {
        $status = [
                1 => '正常',
                2 => '停用',
                3 => '假的'
        ];
        return $status[$value];
    }

    /**
     * 定义数据库中不存在的字段（获取器）
     *
     * @param unknown $value            
     * @param unknown $data            
     */
    public function getStatusTextAttr ($value, $data)
    {
        $status = [
                - 1 => '删除',
                0 => '禁用',
                1 => '正常',
                2 => '待审核'
        ];
        return $status[$data['status']];
    }

    public function setStatusAttr ()
    {
        return 1;
    }

    /**
     * 修改器
     *
     * @param unknown $value            
     * @return string
     */
    public function setNameAttr ($value)
    {
        return strtoupper($value);
    }

    /**
     * 修改器
     */
    protected function setIpAttr ()
    {
        return request()->ip();
    }
}
