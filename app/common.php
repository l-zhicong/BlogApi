<?php
// 应用公共文件

use app\lib\exception\MsgException;

if (!function_exists('E')) {
    /**
     * 抛出异常处理
     *
     * @param string $msg 异常消息
     * @param integer $code 异常代码 默认为0
     *
     * @throws Exception
     */
    function E($msg, $code = null)
    {
        throw new MsgException($msg,$code);
    }
}