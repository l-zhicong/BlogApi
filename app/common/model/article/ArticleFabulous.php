<?php
/**
 * author lzcong
 * Date: 2022/2/16
 * Time: 18:45
 * comment:文件说明
 */

/**
 * Class ArticleFabulous
 * @package app\common\model\article
 * author:lzcong
 * time:18:45
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */


namespace app\common\model\article;


use app\common\model\BaseModel;

class ArticleFabulous extends BaseModel
{
    protected $table = 'article_fabulous';

    public function article()
    {
        return $this->hasOne(Article::class,'id','article_id');
    }
}