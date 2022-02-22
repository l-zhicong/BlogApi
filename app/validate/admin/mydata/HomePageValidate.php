<?php
namespace app\validate\admin\mydata;
use app\validate\BaseValidate;

/**
 * Class HomePageValidate
 * @package app\validate\admin\mydata
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class HomePageValidate extends BaseValidate
{
    protected $failException = true;

    protected $rule = [
        'name|名称' => 'require',
        'synopsis|简介' => 'require|max:200',
        'is_app|是否应用' => 'require',
        'skils|技能' => 'require|array',
        'img_class_ids|相片组id' => 'require|array',
    ];

}