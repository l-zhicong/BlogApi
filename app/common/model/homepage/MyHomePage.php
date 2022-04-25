<?php
namespace app\common\model\homepage;
use app\common\model\BaseModel;

/**
 * Class MyHomePage
 * @package app\common\model\mydata
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class MyHomePage extends BaseModel
{
    protected $table = 'myhomepage';
    protected $pk = "id";

    public function Img()
    {
        return $this->hasMany(MyHomePageImg::class,'home_id');
    }

    public function Skills()
    {
        return $this->hasMany(MyHomePageSkills::class,'home_id');
    }

    public function search(array $where,int $is_app = 0,int $is_del = 0)
    {
        return $this->when($is_app !== null, function ($query) use ($is_app) {
            $query->where('is_app', $is_app);
        })->when($is_del !== null, function ($query) use ($is_del) {
            $query->where('is_del', $is_del);
        });
    }
}