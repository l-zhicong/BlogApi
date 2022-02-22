<?php
/**
 * Class MyHomePageSkills
 * @package app\common\model\mydata
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\model\homepage;

use app\common\model\BaseModel;

class MyHomePageSkills extends BaseModel
{
    protected $table = "myhomepage_skills";

    protected $pk = "home_id";
}