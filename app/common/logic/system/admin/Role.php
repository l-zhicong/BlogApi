<?php
/**
 * Class Article
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\system\admin;

use app\common\logic\Base;
use app\common\model\system\SystemRole;

class Role extends Base
{
    public function __construct()
    {
        $this->model = new SystemRole();
    }

    public function getMenuTree(int $plat){
        $MenuLogic = new Menu;
        return $MenuLogic->getTree($plat);
    }

}