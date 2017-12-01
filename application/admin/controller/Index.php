<?php
namespace app\admin\controller;
use app\admin\model\Rule;
use docParser\DocParser;
/**
 * 首页管理
 * @author baibai
 *
 */
class Index extends Common
{

    public function _initialize ()
    {
        parent::_initialize();
    }
    /**
     * 首页
     * @return mixed
     */
    public function index (Rule $rule,DocParser $doc)
    {
        $menu_list = $rule->getAllClass($doc,'list');
        $this->assign('menu_list',$menu_list);
        return $this->fetch('index');
    }
    /**
     * right
     * @return mixed
     */
    public function main ()
    {
        return $this->fetch();
    }
}
