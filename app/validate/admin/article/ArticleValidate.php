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
        'account|管理员账号' => 'require|max:11',
        'pwd|密码' => 'require',
        'real_name|管理员姓名' => 'integer|max:10',
        'roles|管理员身份' => 'array'
    ];

    public function isUpdate(){
        return $this;
    }
}