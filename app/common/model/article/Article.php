<?php
/**
 * author lzcong
 * Date: 2022/2/16
 * Time: 18:45
 * comment:文件说明
 */

/**
 * Class Article
 * @package app\common\model\article
 * author:lzcong
 * time:18:45
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\model\article;


use app\common\model\BaseModel;

class Article extends BaseModel
{
    protected $table = 'article';
    protected $autoWriteTimestamp = true;//自动时间戳

    protected $type = [
        'release_time'  =>  'timestamp',
    ];

    public function content()
    {
        return $this->hasOne(ArticleContent::class,'article_content_id','id');
    }

    public function Fabulous()
    {
        return $this->hasMany(ArticleFabulous::class,'article_id','id');

    }

    public function articleCategory()
    {
        return $this->hasOne(ArticleCategory::class ,'article_category_id','cid')
            ->field('article_category_id,title');
    }

    public function search(array $where)
    {
        return $this->when(isset($where['status']) && $where['status'] !== '', function ($query) use ($where) {
            $query->where('status', $where['status']);
        })->when(isset($where['cid']) && $where['cid'] !== '', function ($query) use ($where) {
            $query->where('cid', $where['cid']);
        })->when(isset($where['id']) && $where['id'] !== '', function ($query) use ($where) {
            $query->where('id', $where['id']);
        })->when(isset($where['title']) && $where['title'] !== '', function ($query) use ($where) {
            $query->whereLike('title', "%{$where['title']}%");
        })->with(['content','articleCategory'])->order('sort DESC,create_time DESC');
    }
}