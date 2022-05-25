<?php
namespace app\common\model\system;
use app\common\model\BaseModel;

/**
 * Class Article
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明 后台用户类model
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class SystemAdmin extends BaseModel
{
    protected $table = 'system_admin';
    protected $pk = "admin_id";
    protected $autoWriteTimestamp = true;
    protected $resultSetType = 'collection';
    protected $type = [
        'last_time' => 'timestamp',
    ];

    public function getInfoByAccount($account)
    {
        return $this->where('account',$account)->find();
    }

    public function getInfoById($adminId)
    {
        $info = $this->where('admin_id',$adminId)->find();
        $info['id'] = $info->admin_id;
        if(!$info) return false;
        return $info;
    }

    public function search(array $where = [], $is_del = 0,$level = true)
    {
        $query = $this->when($is_del !== null, function ($query) use ($is_del) {
            $query->where('is_del', $is_del);
        });
        if($level) $query->where('level','<>',0);
        return $query;
    }

    public function roleNames($isArray = false)
    {
        $roleModel = new SystemRole();
        $roleNames = $roleModel->whereIn('role_id', $this->roles)->column('role_name');
        return $isArray ? $roleNames : implode(',', $roleNames);
    }

    public function getRolesAttr($value)
    {
        return array_map('intval', explode(',', $value));
    }

    public function setRolesAttr($value)
    {
        return implode(',', $value);
    }

    public function fieldExists($field, $value, $except = null)
    {
        $query = $this->where($field, $value)->where('is_del', 0);
        if (!is_null($except)) $query->where($this->pk, '<>', $except);
        return $query->count() > 0;
    }

}