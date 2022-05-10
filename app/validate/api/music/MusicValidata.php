<?php
namespace app\validate\api\music;

use app\validate\BaseValidate;

/**
 * Class MusicValidata
 * @package ${NAMESPACE}
 * author:lzcong
 * time:16:04
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class MusicValidata extends BaseValidate
{
    protected $failException = true;

    public $rule = [
        'name|名称' => 'string',
        'limit|页数' => 'int',
    ];

    public function getList(){


        return $this;
    }

}