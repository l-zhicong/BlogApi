<?php
/**
 * Class Letter
 * @package app\common\logic\homepage
 * author:lzcong
 * time:12:28
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\homepage;

use app\common\logic\Base;
use app\common\model\homepage\MyHomePageLetter;

class Letter extends Base
{
    public function __construct()
    {
        $this->model = new MyHomePageLetter();
    }


    public function create($data){
        $res = $this->model->create($data);
        return $res->toArray();
    }

}