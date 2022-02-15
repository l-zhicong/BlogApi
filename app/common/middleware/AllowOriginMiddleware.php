<?php

namespace app\common\middleware;


use app\Request;
use think\facade\Config;
use think\Response;

/**
 * 跨域中间件
 */
class AllowOriginMiddleware extends BaseMiddleware
{
    protected $header = [
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Max-Age'           => 1800,
        'Access-Control-Allow-Methods'     => 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers'     => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-CSRF-TOKEN, X-Requested-With, X-token, force,Access-Token',
    ];

    public function before(Request $request)
    {
        $cookieDomain = Config::get('cookie.domain', '');

        if (!isset($this->header['Access-Control-Allow-Origin'])) {
            $origin = $request->header('origin');
            if ($origin && ('' == $cookieDomain || strpos($origin, $cookieDomain))) {
                $this->header['Access-Control-Allow-Origin'] = $origin;
            } else {
                $this->header['Access-Control-Allow-Origin'] = '*';
            }
        }

        //杨秦伟 2020-04-15  如果为options方法，直接返回200状态
        if($request->isOptions()) {
            header('HTTP/1.1 200 OK');
            exit;
        }
    }

    public function after(Response $response)
    {
        // $response->header($this->header);
    }
}
