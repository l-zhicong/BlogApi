<?php
namespace app\validate\admin\setting;


use app\validate\BaseValidate;

class SystemRoleValidata extends BaseValidate
{
    protected $failException = true;

    protected $rule = [
        'role_name|管理名称' => 'require|max:32',
        'rules|权限' => 'require|array|min:1',
        'status|是否启用' => 'require',
    ];


}
