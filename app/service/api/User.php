<?php

namespace app\service\api;

use app\common\logic\user\Passport;

class User
{
    private $plat = 3;

    /**
     * 登陆
     * @param $account 账号
     * @param $password 密码
     * @param $platkey 平台key
     * @param $code    验证码
     * @return string
     * @throws \app\lib\exception\PlatException
     */
    public function login($phone,$password,$platkey,$code){

//        $cachePlat = cache('plat_'.$platkey);
//        if(!$cachePlat) throw new PlatException('平台参数错误');
//        if($cachePlat != $this->plat) throw new PlatException('平台参数错误');
        $passportObj = Passport::getInstance($this->plat);
//        $passportObj->checkCode($platkey, $code);
        $param = [
            'phone' => $phone,
            'pwd' => $password
        ];
        $UserObj = $passportObj->login($param);
        $tokenInfo = $passportObj->createToken($UserObj->id);
        return $tokenInfo;
    }

    public function logout(){
//        if ($this->request->isLogin()){
//            $passportObj = Passport::getInstance($this->request->plat());
//            $passportObj->clearToken($this->request->userToken());
//        }
        return "退出登录";
    }


    public function register($param){
        $passportObj = Passport::getInstance($this->plat);
        $res = $passportObj->register($param);
        return $res;
    }

}