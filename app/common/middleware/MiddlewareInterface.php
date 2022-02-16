<?php
namespace app\common\middleware;


use app\Request;

interface MiddlewareInterface
{
    public function handle(Request $request, \Closure $next);
}
