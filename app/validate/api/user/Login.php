<?php
namespace app\validate\api\user;

use app\validate\BaseValidate;
/**
 * Class Login
 * @package ${NAMESPACE}
 * author:lzcong
 * time:17:30
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */
class Login extends BaseValidate
{
    protected $failException = true;

    public $rule = [
        'phone|手机号码' => 'require',
        'pwd|密码' => 'require'
    ];

    public function isRegister(){
        $this->rule['name|昵称'] = 'require|max:30';
        $this->rule['againPwd|确认密码'] = 'require';
//        $this->rule['code|短信验证码'] = 'require'; 没有钱不做
        return $this;
    }

}