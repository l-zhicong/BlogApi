<?php
/**
 * Class MyHomePageLetter
 * @package app\common\model\homepage
 * author:lzcong
 * time:12:24
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\model\homepage;

use app\common\model\BaseModel;

class MyHomePageLetter extends BaseModel
{
    protected $table = 'myhomepage_letter';
    protected $pk = "id";

    public function search(array $where)
    {
        return $this->when(isset($where['name']) && $where['name'] !== '', function ($query) use ($where) {
            $query->where('name', $where['name']);
        });
    }

}