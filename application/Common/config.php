<?php
//配置文件
return [
        'API_URL'=>'http://api.think.com',
        'template'  =>  [
                'layout_on'     =>  true,
                'layout_name'   =>  'layout',
        ],
        'role_file'=> [
                'admin'=>APP_PATH.'/admin/controller',
                'demo'=>APP_PATH.'/demo/controller',
        ],
        //不验证权限文件
        'filter_arr' => [
                'admin'=> ['Login','Common','Index'],
                'demo' => ['Index'],
        ],
];