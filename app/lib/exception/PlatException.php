<?php

namespace app\lib\exception;

/**
 * 平台错误
 */
class PlatException extends BaseException
{
    public $code = 403;
    public $errorCode = 10001;

    public function __construct($message='平台错误', \Throwable $previous = null)
    {

        if (is_array($message)) {
            $errInfo = $message;
            $message = $errInfo[1] ?? '未知错误';
            if ($this->code === 0) {
                $code = $errInfo[0] ?? 400;
            }
        }

        parent::__construct($message, $code, $previous);
    }
}