<?php
namespace app\common\model\system;
use app\common\model\BaseModel;

/**
 * Class Article
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明 后台权限model
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class SystemRole extends BaseModel
{
    protected $table = 'system_role';
    protected $pk = "role_id";
    protected $autoWriteTimestamp = true;
    protected $resultSetType = 'collection';

    public function search($platId, $where = [])
    {
        $roleModel = $this;
        return $roleModel->where('plat_id', $platId)->select()->toArray();
    }

    public function ruleNames($isArray = false)
    {
        $systemMenuModel = new SystemMenu();
        $menusName = $systemMenuModel->whereIn('menu_id', $this->rules)->column('menu_name');
        return $isArray ? $menusName : implode(',', $menusName);
    }

    public function getRulesAttr($value)
    {
        return array_map('intval', explode(',', $value));
    }

    public function setRulesAttr($value)
    {
        return implode(',', $value);
    }

    public function idsByRules($platId, $ids)
    {
        $rules = $this->where('status', 1)->where('plat_id', $platId)->whereIn($this->pk, $ids)->column('rules');
        $data = [];
        foreach ($rules as $rule) {
            $data = array_merge(explode(',', $rule), $data);
        }
        return array_unique($data);
    }

    public function platExists($id,$platType,$platId = 1)
    {
        return $this->where($this->pk, $id)->where('plat_type', $platType)->where('plat_id',$platId)->find();
    }

    public function getAllOptions($platType)
    {
        return $this->where('status', 1)->where('plat_type', $platType)->column('role_name', 'role_id');
    }

}