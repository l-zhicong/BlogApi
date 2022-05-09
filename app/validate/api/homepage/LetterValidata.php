<?php
namespace app\validate\api\homepage;
use app\validate\BaseValidate;

/**
 * Class LetterValidata
 * @package ${NAMESPACE}
 * author:lzcong
 * time:16:00
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class LetterValidata extends BaseValidate
{
    protected $failException = true;

    protected $rule = [
        'name|名称' => 'string',
        'email|邮箱' => 'email',
        'message|信息' => 'string'
    ];

    public function sendOut(){


        return $this;
    }

}