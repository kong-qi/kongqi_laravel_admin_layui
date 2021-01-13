<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        ErrorException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException){
            if($request->wantsJson()){
                return response()->json(['code'=>1,'msg'=>'操作太频繁']);
            }
            return abort('401','操作太频繁');
        }
        if ($exception instanceof \illuminate\auth\access\authorizationexception) {
            if($request->wantsJson()){
                return response()->json(['code'=>1,'msg'=>'没有权限']);
            }
            return abort(403,'没有权限');
        }
        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            if($request->wantsJson()){
                return response()->json(['code'=>1,'msg'=>'没有权限']);
            }
            return abort(403,'没有权限');
        }
        if ($exception instanceof TokenMismatchException) {

            if($request->wantsJson()){
                return response()->json(['code'=>1,'msg'=>'过期请刷新页面']);
            }
            return abort('401','过期请刷新页面');
        }
        return parent::render($request, $exception);

    }
}
