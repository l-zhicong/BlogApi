<?php
/**
 * Class AppUser
 * @package app\common\logic\user
 * author:lzcong
 * time:22:13
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\logic\user;

use app\common\logic\Base;
use app\common\model\user\User;

class AppUser extends Base implements AbsUser
{
    public function __construct()
    {
        $this->model = new User();
    }

    public function login($param)
    {
        $phone = $param['phone'];
        $pwd = md5($param['pwd']);
        $AppUserInfo = $this->model->getPhoneInfo($phone);
        if(!$AppUserInfo) E('账号不存在');
        switch ($AppUserInfo['status']){
            case 1:
                E('账号注销中');
            case 2:
                E('账号已拉黑');
        }
        if($pwd != $AppUserInfo->pwd) E('密码错误');
        $AppUserInfo->last_time = time();
        $AppUserInfo->last_ip = request()->ip();
        $AppUserInfo->login_count++;
        $AppUserInfo->save();
        return $AppUserInfo;
        // TODO: Implement login() method.
    }

    public function getInfo($uid)
    {
        // TODO: Implement getInfo() method.
    }

    public function register($param){
        if ($param["pwd"] != $param["againPwd"])E("密码不一致");
        $UserObj = $this->model->where("phone",$param["phone"])->find();
        if ($UserObj)E("账号已注册");
        $data = [
            "name" => $param["name"],
            "phone" => $param["phone"],
            "pwd" => md5($param["pwd"]),
            "register_time" => time(),
            "ip" => request()->ip()
        ];
        $res = $this->model->create($data);
        return $res;
    }

    /**
     * 微信登陆 扫码
     * @return void
     */
    public function wxLogin($accToken ,$param)
    {

    }

}