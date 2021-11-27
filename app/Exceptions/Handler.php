<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    //オリジナルデザインのエラー画面をレンダリング
    protected function renderHttpException($e)
    {
        $status = $e->getStatusCode();
        $header = $e->getHeaders();
        return response()->view('errors.common', ['exception'=>$e],
            $status, //レスポンス自体のステータスコード
            $header
        );
    }

}
