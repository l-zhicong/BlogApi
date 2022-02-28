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

namespace app\common\middleware;


use app\common\logic\user\Passport;
use app\common\utils\ApiErrorCode;
use app\lib\exception\AuthException;
use app\Request;
use Firebase\JWT\ExpiredException;
use think\Response;
use app\common\utils\JwtAuth;
use Throwable;

/**
 * Class AdminTokenMiddleware
 * @package app\api\middleware
 */
class AdminTokenMiddleware extends BaseMiddleware
{
    public function before(Request $request)
    {
//        $plat = $request->param('plat');//中后台才有的参数
        $token = trim($request->header('X-Token'));
        if (strpos($token, 'Bearer') === 0)
            $token = trim(substr($token, 6));
        if(!$token) throw new AuthException(ApiErrorCode::ERR_LOGIN);

        $jwtAuthObj = new JwtAuth();
        [$id,$type,$plat] = $jwtAuthObj->parseToken($token);
        try {
            $jwtAuthObj->verifyToken();
        } catch (ExpiredException $e) { //token 续期
            $passportObj = Passport::getInstance($plat);
            $passportObj->checkToken($token);
        } catch (Throwable $e) { //Token 过期
//            存map 判断是否用到map再抛登录异常
            throw new AuthException(ApiErrorCode::ERR_LOGIN_INVALID);
        }
        $passportObj = Passport::getInstance($plat);//暂时特殊处理
        $userInfo = $passportObj->getInfo($id);
        $request::macro('adminId', function () use (&$userInfo) {
            return $userInfo["admin_id"];
        });
        $request::macro('userInfo', function () use (&$userInfo) {
            return $userInfo;
        });
        $request::macro('plat', function () use (&$plat) {
            return $plat;
        });
    }

    public function after(Response $response)
    {
        // TODO: Implement after() method.
    }
}
