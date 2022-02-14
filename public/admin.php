<?php
/**
 * Created by PhpStorm.
 * AdminUser: Administrator
 * Date: 2022/2/8
 * Time: 10:38
 */

// [ 应用入口文件 ]
namespace think;

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http;

$response = $http->run();
$key = md5(uniqid(microtime(true), true));
switch (input('plat_key')) {
    case env('platkey_adminsystem'):
        $plat = 1;
        break;
    case env('platkey_schoolsystem'):
        $plat = 2;
        break;
    default:
        echo json_encode(['code'=>205,'msg'=>'参数错误','data'=>'']);exit;
        break;
}
cache('plat_' . $key, $plat, 600);
echo json_encode(['code'=>201,'msg'=>'ok','data'=>$key]);
$response->send();

$http->end($response);
