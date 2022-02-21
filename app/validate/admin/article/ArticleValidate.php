<?php
namespace app\validate\admin\article;
use app\validate\BaseValidate;

/**
 * Class Article
 * @package app\qjzp\controller\article
 * author:lzcong
 * time:11:58
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class ArticleValidate extends BaseValidate
{

    protected $failException = true;

    protected $rule = [
        'cid|选择分类' => 'require',
        'name|文章名称' => 'require',
//        'logo|文章logo' => 'require',
        'title|标题' => 'require',
        'abstract|摘要' => 'require',
        'content|正文' => 'require',
        'related_words|关联词' => 'require',
        'source|来源' => 'require',
        'author|作者' => 'require',
        'release_time|发布时间' => 'integer'
    ];

    //后面再做限制
    public function isUpdate()
    {
        return $this;
    }

    public function isRead()
    {
        $this->rule = [
            'id' => 'require',
        ];
        return $this;
    }

    public function isFabulous()
    {
        $this->rule = [
            'id'=> 'require'
        ];
        return $this;
    }
}