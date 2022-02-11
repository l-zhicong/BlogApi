<?php
namespace app;

use app\lib\exception\AdminException;
use app\lib\exception\ApiException;
use app\lib\exception\AuthException;
use app\lib\exception\MsgException;
use app\lib\exception\PlatException;
use app\lib\exception\ValiException;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\facade\Env;
use think\Response;
use Throwable;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{

    private $code;
    private $msg;
    private $errorCode;

    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValiException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param  Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        // 使用内置的方式记录异常日志
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request   $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        $massageData = Env::get('app_debug', false) ? [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
            'previous' => $e->getPrevious(),
        ] : [];
        // 添加自定义异常处理机制
        if ($e instanceof DbException) {
//            return app('json')->fail('数据获取失败', $massageData);
        } elseif (
            $e instanceof ValiException ||
            $e instanceof ApiException ||
            $e instanceof PlatException ||
            $e instanceof MsgException  ||
            $e instanceof AdminException ||
            $e instanceof AuthException
        ) {
            return app('json')->make($e->getCode() ?: 400, $e->getMessage(), $massageData);
        }
        // 其他错误交给系统处理
        return parent::render($request, $e);
    }

    /*
     * 将异常写入日志
     */
    private function recordErrorLog(Exception $e)
    {
//        Log::record($e->getMessage(),'error');
    }
}
