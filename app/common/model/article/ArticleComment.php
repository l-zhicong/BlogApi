<?php
/**
 * Class ArticleComment
 * @package app\common\model\article
 * author:lzcong
 * time:16:37
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\model\article;

use app\common\model\BaseModel;

class ArticleComment extends BaseModel
{
    protected $table = 'article_comment';
    protected $pk = 'id';


    public function search(array $where)
    {
        return $this->when(isset($where['article_id']) && $where['article_id'] !== '', function ($query) use ($where) {
            $query->where('article_id', $where['article_id']);
        });
    }
}