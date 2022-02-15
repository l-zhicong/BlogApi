<?php
namespace app\common\model;

use think\Model;

class BaseModel extends Model
{

    public function fieldExists($field, $value, $except = null)
    {
        $query = $this->where($field, $value);
        if (!is_null($except)) $query->where($this->pk, '<>', $except);
        return $query->count() > 0;
    }

    public function existsWhere($where)
    {
        return $this->where($where)->count() > 0;
    }

    public function getWhereFind($where)
    {
        return $this->where($where)->find();
    }

    public function getWhereAll($where)
    {
        return $this->where($where)->select();
    }

    public function getField($id,$field)
    {
        return $this->where($this->pk,$id)->value($field);
    }

    /**
     * 自增
     */
    public function incField(int $id, string $field , $num = 1)
    {
        return $this->where($this->pk,$id)->setInc($field,$num);
    }

    /**
     * 自减
     */
    public function decField(int $id, string $field , $num = 1)
    {
        return $this->where($this->pk,$id)->setDec($field,$num);
    }

}