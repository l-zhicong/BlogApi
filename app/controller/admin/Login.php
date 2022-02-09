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
use app\common\service\user\Passport;
use app\common\utils\Captcha;
use app\lib\exception\PlatException;
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
     * @param SystemAdminServices $services
     */
    public function __construct(App $app)
    {
        parent::__construct($app);
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
        [$account, $password, $platkey,$code] = $this->request->postMore([
            'account', 'pwd', ['plat_key', ''],'code'
        ], true);

        $data = $this->request->post();
//        if (!app()->make(Captcha::class)->check($imgcode)) {
//            return $this->fail('验证码错误，请重新输入');
//        }
        $validate->isLogin()->goCheck();
        $plat = cache('plat_'.$platkey);
        if(!$plat) throw new PlatException('平台参数错误');
        if($plat != input('plat')) throw new PlatException('平台参数错误');
        $passportObj = Passport::getInstance($plat);
        $passportObj->checkCode($platkey, $code);
        $admin = $passportObj->login($data);
        $tokenInfo = $passportObj->createToken($admin->admin_id);
        return $this->success($this->services->login($account, $password, 'admin'));
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
