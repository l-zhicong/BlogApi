<?php
namespace app\common\model\music;
use app\common\model\BaseModel;
/**
 * Class music
 * @package ${NAMESPACE}
 * author:lzcong
 * time:16:00
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class music extends BaseModel
{
    protected $table = 'music';
    protected $pk = "id";


    public function search(array $where,$isDel = 1)
    {
        return $this->when(isset($where['name']) && $where['name'] !== '', function ($query) use ($where) {
            $query->where('name', $where['name']);
        });
    }


}