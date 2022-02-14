<?php

namespace app\common\middleware;
use think\Exception;
use app\Request;
use think\Response;
use think\facade\Route;
class RolesAuthMiddleware extends BaseMiddleware
{

    public function before(Request $request)
    {
        $userInfo = $request->userInfo();
        $roleObj = new \logic\admin\Role();
        $menuObj = new \logic\admin\Menu();
        if (isset($userInfo->level) && !empty($userInfo->level)) {
            if($request->plat() == 1){
                $platId = 0;
            }else{
                $platId = $request->userInfo()->school_id;
            }
            $rules = $roleObj->idsByRules($platId, $userInfo->roles);
            $menus = $menuObj->idsByRoutes($rules);
        } else {
            $userInfo->level = 0;
            $rules = [];
            $menus = [];
        }
        $request->macro('adminAuth', function () use (&$menus) {
            // array(3) {
            //   [0] => string(10) "/dashboard"
            //   [1] => string(5) "/user"
            //   [2] => string(10) "/user/list"
            // }
            return $menus;
        });
        $request->macro('adminRule', function () use (&$rules) {
            //[1,2,3]
            return $rules;
        });
        $request->macro('checkAuth', function ($rule,$plat) use (&$userInfo, &$menus, &$menuObj) {
            if (!$rule || !$userInfo->level) return true;
            if(!$menuObj->routeExists($rule,$plat)) return true;//未配置菜单就给他权限
            if (!in_array($rule,$menus)) return false;
            return true;
        });
        // halt(app('route')->ruleItem());
        // $rule = '/'.$request->routeInfo()['rule'];
        $rule = isset($request->routeInfo()['option']['alias']) ? $request->routeInfo()['option']['alias'] : '';
        if (!$request->checkAuth($rule,$request->plat()))
            E('没有权限访问');
    }

    public function after(Response $response)
    {
        // TODO: Implement after() method.
    }
}