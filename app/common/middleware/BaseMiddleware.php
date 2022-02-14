<?php

namespace app\common\middleware;


use app\Request;
use think\Response;

abstract class BaseMiddleware implements MiddlewareInterface
{

    /**
     * @var Request
     */
    protected $request;

    abstract public function before(Request $request);

    final public function handle(Request $request, \Closure $next, ...$args): Response
    {
        $this->request = $request;
        $this->before($request);
        $response = $next($request);
        $this->after($response);
        return $response;
    }

    abstract public function after(Response $response);
}