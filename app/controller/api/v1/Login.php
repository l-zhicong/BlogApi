<?php
/**
 * Class Login
 * @package app\controller\api\v1
 * author:lzcong
 * time:22:20
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\controller\api\v1;

use app\common\Base\ApiBaseController;
use think\App;
use app\service\api\User as UserServer;
use app\validate\api\user\Login as LoginValidate;

class Login extends ApiBaseController
{

    public function __construct(App $app,UserServer $service,LoginValidate $validate)
    {
        parent::__construct($app);
        $this->service = $service;
        $this->validate = $validate;
    }

    public function login(){
        $this->validate->goCheck();
        [$phone, $password, $platkey ,$code] = $this->request->postMore([
            'phone', 'pwd', ['plat_key', ''],'code'
        ], true);
        return $this->success($this->service->login($phone,$password,$platkey,$code));
    }

    public function register(){
        $this->validate->isRegister()->goCheck();
        $param = $this->request->postMore([
            'phone', 'pwd','againPwd','name'
        ]);
        try {
            $this->service->register($param);
            return $this->success([]);
        }catch (\Exception $e){
            return $this->fail($e->getMessage());
        }
    }

}