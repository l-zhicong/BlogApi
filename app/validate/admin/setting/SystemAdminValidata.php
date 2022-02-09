<?php
namespace app\validate\admin\setting;


use app\validate\BaseValidate;

class SystemAdminValidata extends BaseValidate
{
    protected $failException = true;

    protected $rule = [
        'account|管理员账号' => 'require|max:11',
        'conf_pwd|确认密码' => 'require',
        'pwd|密码' => 'require',
        'real_name|管理员姓名' => 'integer|max:10',
        'roles|管理员身份' => 'array'
    ];

//    public function gtTime($value,$rule,$data){
//        if($value < time() + 60*60)
//        {
//            return '面试时间必须大于当前时间的一小时';
//        }
//        return true;
//    }

    public function isLogin(){
        $this->rule = [
        'account|管理员账号' => 'require|max:11',
        'conf_pwd|确认密码' => 'require|gtTime',
        'pwd|密码' => 'require',
        ];
        return $this;
    }


}
