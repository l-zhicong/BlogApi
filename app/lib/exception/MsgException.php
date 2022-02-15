<?php

namespace app\lib\exception;

/**
 * 提示信息
 */
class MsgException extends BaseException
{
	public $code = 400;
    public $errorCode = 10001;

	public function __construct($message='平台错误',$code = 0)
    {
        if (is_array($message)) {
            $errInfo = $message;
            $message = $errInfo[1] ?? '未知错误';
            if ($this->code === 0) {
                $code = $errInfo[0] ?? $this->code;
            }
        }
//        if ($code == null){
//            $code = $this->code;
//        }

        parent::__construct($message, $code);
    }
}