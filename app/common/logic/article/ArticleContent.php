<?php
/**
 * author lzhicong
 * Date: 2022/2/16
 * Time: 14:35
 * comment:文件说明
 */

/**
 * Class ArticleContent
 * @package app\common\logic\article
 * author:lzhicong
 * time:14:35
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\article;
use app\common\logic\Base;
use app\common\model\article\ArticleContent as model;

class ArticleContent extends Base
{
    public function __construct(model $model)
    {
        $this->model = $model;
    }
}