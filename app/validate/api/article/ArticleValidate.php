<?php
namespace app\validate\api\article;
use app\validate\BaseValidate;

/**
 * Class ArticleValidate
 * @package ${NAMESPACE}
 * author:lzcong
 * time:15:50
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class ArticleValidate extends BaseValidate
{
    protected $failException = true;

    protected $rule = [
        'limit|选择分类' => 'int',
        'name|文章名称' => 'string',
        'limit|页数' => 'int'
    ];

    public function getInfo(){
        $this->rule = [
            'id' => 'require',
        ];
        return $this;
    }

    public function comment(){
        $this->rule = [

        ]; // 数据库的字段
        return $this;
    }

}