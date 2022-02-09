<?php
namespace app\lib\exception;

/**
 * API应用错误信息
 * Class ApiException
 * @package crmeb\exceptions
 */
class ValiException extends BaseException
{
    public $code = 400;
    public $errorCode = 10001;

    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        if (is_array($message)) {
            $errInfo = $message;
            $message = $errInfo[1] ?? '未知错误';
            if ($code === 0) {
                $code = $errInfo[0] ?? 400;
            }
        }

        parent::__construct($message, $code, $previous);
    }
}