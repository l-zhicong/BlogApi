<?php
namespace app\common\logic\user;


use app\common\logic\Base;
use app\common\model\system\SystemAdmin as AdminUserModel;

class AdminUser extends Base implements AbsUser {

    public function __construct()
    {
        $this->model = new AdminUserModel();
    }

    public function login($param)
    {
        $account = $param['account'];
        $pwd = md5($param['pwd']);
        $adminInfo = $this->model->getInfoByAccount($account);
        if(!$adminInfo) E('账号不存在');
        if($adminInfo['status'] != 1) E('账号已关闭');
        if($pwd != $adminInfo->pwd) E('密码错误');
        $adminInfo->last_time = time();
        $adminInfo->last_ip = request()->ip();
        $adminInfo->login_count++;
        $adminInfo->save();
        return $adminInfo;
    }

    public function getInfo($adminId)
    {
        // TODO: Implement getInfo() method.
        $userObj = $this->model->getInfoById($adminId);
        $userArray = $userObj->toArray();
        $userArray["name"] = $userObj->real_name;
        return $userArray;
    }
}