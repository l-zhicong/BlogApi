<?php
/**
 * author lzcong
 * Date: 2022/2/16
 * Time: 18:45
 * comment:文件说明
 */

/**
 * Class ArticleCategory
 * @package app\common\model\article
 * author:lzcong
 * time:18:45
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
namespace app\common\model\article;


use app\common\model\BaseModel;

class ArticleCategory extends BaseModel
{
    protected $table = 'article_category';
    protected $pk = 'article_category_id';
    protected $autoWriteTimestamp = true;//自动时间戳

    public function search(array $where)
    {
        return $this->when(isset($where['status']) && $where['status'] !== '', function ($query) use ($where) {
            $query->where('status', $where['status']);
        })->when(isset($where['pid']) && $where['pid'] !== '', function ($query) use ($where) {
            $query->where('pid', $where['pid']);
        })->when(isset($where['article_category_id']) && $where['article_category_id'] !== '', function ($query) use ($where) {
            $query->where('article_category_id', $where['article_category_id']);
        })->order('sort DESC, article_category_id DESC');
    }
}