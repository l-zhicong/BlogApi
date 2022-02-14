<?php
namespace app\service\admin\user;

use app\common\logic\user\Passport;
use app\lib\exception\PlatException;

class Login
{
    private $plat = 1;

    /**
     * 登陆
     * @param $account 账号
     * @param $password 密码
     * @param $platkey 平台key
     * @param $code    验证码
     * @return string
     * @throws \app\lib\exception\PlatException
     */
    public function login($account,$password,$platkey,$code){

//        $cachePlat = cache('plat_'.$platkey);
//        if(!$cachePlat) throw new PlatException('平台参数错误');
//        if($cachePlat != $this->plat) throw new PlatException('平台参数错误');
        $passportObj = Passport::getInstance($this->plat);
//        $passportObj->checkCode($platkey, $code);
        $param = [
            'account' => $account,
            'pwd' => $password
        ];
        $admin = $passportObj->login($param);
        $tokenInfo = $passportObj->createToken($admin->admin_id);
        return $tokenInfo;
    }

    public function logout()
    {
//        if ($this->request->isLogin()){
//            $passportObj = Passport::getInstance($this->request->plat());
//            $passportObj->clearToken($this->request->userToken());
//        }
        return "退出登录";
    }

}