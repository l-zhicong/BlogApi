<?php
/**
 * Class MyHomePageImg
 * @package app\common\model\mydata
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\model\homepage;

use app\common\model\BaseModel;

class MyHomePageImg extends BaseModel
{
    protected $table = "myhomepage_img";

    protected $pk = "img_class_id";

}