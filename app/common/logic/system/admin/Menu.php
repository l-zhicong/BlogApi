<?php
namespace app\common\logic\system\admin;

use app\common\logic\Base;
use app\common\model\system\SystemMenu;

/**
 * Class Article
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class Menu extends Base
{
    public function __construct()
    {
        $this->model = new SystemMenu();
    }

    public function add($data)
    {
        $data['path'] = '/';
        if ($data['pid']) {
            $data['path'] = $this->model->getPath($data['pid']) . $data['pid'] . '/';
        }
        return $this->model->save($data);
    }

    public function getList($where, $plat = 1)
    {
        $query = $this->model->search($where, $plat);
        $count = $query->count();
        $list = $query->select()->hidden(['update_time', 'path'])->toArray();
        return compact('count', 'list');
    }

    public function menuForm($platType = 1, $id = null)
    {
        $menus = $this->model->getAllOptions($platType);
        if ($id && isset($menus[$id])) unset($menus[$id]);
        $menus = formatCascaderData($menus, 'menu_name');
        array_unshift($menus, ['label' => '顶级分类', 'value' => 0]);
        return $menus;
    }

    public function getTree($platType = 1)
    {
        $options = $this->model->getAllOptions($platType);
        return formatTree($options, 'menu_name');
    }

}