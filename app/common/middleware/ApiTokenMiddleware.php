<?php
/**
 * Class ApiTokenMiddleware
 * @package app\common\middleware
 * author:lzcong
 * time:17:13
 * comment:说明
 * package:包命，命名空间
 * todo todolis:类中还需要完善的功能列表
 */

namespace app\common\middleware;

use app\Request;
use think\Exception;
use think\Response;

class ApiTokenMiddleware extends BaseMiddleware
{

    public function before(Request $request)
    {
        $token = $request->header("A-Token");
        if (!isset($token)){
            throw new Exception();
        }
        // TODO: Implement before() method.
    }

    public function after(Response $response)
    {
        // TODO: Implement after() method.
    }

}