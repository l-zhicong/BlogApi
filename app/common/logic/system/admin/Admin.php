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
use app\common\model\system\SystemAdmin;
use app\common\model\system\SystemRole;

class Admin extends Base
{
    public function __construct()
    {
        $this->model = new SystemAdmin();
    }

    public function getList(array $where, $page, $limit)
    {
        $query = $this->model->search($where);
        $count = $query->fetchSql(true)->count();
        $list = $query->paginate(['page'=>$page],false)->hidden(['pwd', 'is_del', 'update_time']);
        foreach ($list as $k => $role) {
            $list[$k]['rule_name'] = $role->roleNames();
        }
        return formatPaginate($list);
    }

    public function roleForm($platType = 1)
    {
        $data = (new SystemRole())->getAllOptions($platType);
        $options = [];
        foreach ($data as $value => $label) {
            $options[] = compact('value', 'label');
        }
        return $options;
    }

}