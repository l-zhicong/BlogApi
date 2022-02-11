<?php
// +----------------------------------------------------------------------
// | CRMEB [ CRMEB赋能开发者，助力企业发展 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2020 https://www.crmeb.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed CRMEB并不是自由软件，未经许可不能去掉CRMEB相关版权
// +----------------------------------------------------------------------
// | Author: CRMEB Team <admin@crmeb.com>
// +----------------------------------------------------------------------
namespace app\controller\admin;

use app\BaseController;
use app\service\admin\user\Login as Service;
use app\common\utils\Captcha;
use app\validate\admin\setting\SystemAdminValidata;
use think\App;

/**
 * 后台登陆
 * Class Login
 * @package app\controller\admin
 */
class Login extends BaseController
{

    /**
     * Login constructor.
     * @param App $app
     * @param Service $services
     */
    public function __construct(App $app,Service $service)
    {
        parent::__construct($app);
        $this->service = $service;
    }

    protected function initialize()
    {
        // TODO: Implement initialize() method.
    }

    /**
     * 验证码
     * @return $this|\think\Response
     */
    public function captcha()
    {
        return app()->make(Captcha::class)->create();
    }

    /**
     * 登陆
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login(SystemAdminValidata $validate)
    {
        [$account, $password, $platkey, $confpwd ,$code] = $this->request->postMore([
            'account', 'pwd','conf_pwd', ['plat_key', ''],'code'
        ], true);
        return $this->success($this->service->login($account,$password,$confpwd,$platkey,$code));
    }

    public function logout()
    {
        return $this->success([],$this->service->logout());
    }

    /**
     * 获取后台登录页轮播图以及LOGO
     * @return mixed
     */
    public function info()
    {
        return $this->success($this->services->getLoginInfo());
    }
}
