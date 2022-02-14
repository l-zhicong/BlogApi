<?php
namespace app\common\model\system;
use app\common\model\BaseModel;

/**
 * Class Article
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明 后台菜单model
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class SystemMenu extends BaseModel
{
    protected $table = 'system_menu';
    protected $pk = "menu_id";
    protected $autoWriteTimestamp = true;
    protected $resultSetType = 'collection';

    public function platExists($id,$plat)
    {
        return $this->where($this->pk, $id)->where('plat_type', $plat)->find();
    }

    public function IdExists($id){
        return $this->where($this->pk, $id)->count() > 0;
    }

    public function pidExists($id)
    {
        return $this->where('pid', $id)->count() > 0;
    }

    public function getPath($id, $plat = 1)
    {
        return $this->where('plat_type', $plat)->where($this->pk, $id)->value('path');
    }

    public function search($where, $plat = 1)
    {
        $query = $this->where('plat_type', $plat)->order('sort DESC,menu_id ASC');
        if (isset($where['pid'])) $query->where('pid', $where['pid']);
        if (isset($where['is_menu'])) $query->where('is_menu', $where['is_menu']);
        return $query;
    }

    public function getValidMenuList($plat = 1)
    {
        return $this->where('is_menu', 1)->where('is_show', 1)->order('sort DESC,menu_id ASC')->where('plat_type', $plat)
            ->column('menu_name,route,icon,pid,menu_id');
    }

    public function ruleByMenuList($rule, $plat = 1)
    {
        $paths = $this->whereIn($this->pk, $rule)->column('path', 'menu_id');
        $ids = [];
        foreach ($paths as $id => $path) {
            $ids = array_merge($ids, explode('/', trim($path, '/')));
            array_push($ids, $id);
        }
        return $this->where('is_menu', 1)->where('is_show', 1)->order('sort DESC,menu_id ASC')->where('plat_type', $plat)
            ->whereIn('menu_id', array_unique(array_filter($ids)))
            ->column('menu_name,route,icon,pid,menu_id');
    }

    public function idsByRoutes($ids)
    {
        return $this->where('is_menu', 0)->whereIn($this->pk, $ids)->column('route');
    }

    public function routeExists($route, $platType = 1)
    {
        return $this->where('route', $route)->where('is_menu', 0)->where('plat_type', $platType)->count() > 0;
    }

    public function getAllOptions($platType = 1)
    {
        return $this->where('plat_type', $platType)->order('sort DESC,menu_id ASC')->column('menu_name,pid', 'menu_id');
    }
}