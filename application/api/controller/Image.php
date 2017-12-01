<?php


namespace app\api\controller;
use think\Controller;

class Image extends Controller
{
    public function _initialize ()
    {
        parent::_initialize();
    }
    
    public function images()
    {
        $data= [1,2,3];
        if($this->request->has('callback'))
        {
            return jsonp($data,200);
        }
        else
        {
            return json($data,200);
        }
    }
}