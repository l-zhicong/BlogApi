<?php
/**
 * Class ArticleCategoryValidate
 * @package app\validate\api\article
 * author:lzcong
 * time:15:57
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\validate\api\article;

use app\validate\BaseValidate;

class ArticleCategoryValidate extends BaseValidate
{
    protected $failException = true;

    protected $rule = [
        'limit|页数' => 'integer'
    ];

}