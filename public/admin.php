<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2022/2/8
 * Time: 10:38
 */

// [ 应用入口文件 ]
namespace think;

require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);
