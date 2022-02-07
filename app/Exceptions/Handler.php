<?php

namespace App\Exceptions;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
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
        FileNotFoundException::class
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {

        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }


        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof FileNotFoundException) {


            $version = $request->route()->parameter('version');
            $doc = $request->route()->parameter('doc');
            \Toastr::error($doc . "는 " . $version . " 버전에 존재하지 않는 문서입니다",null, [
                "positionClass" => "toast-top-full-width",
            ]);
            return redirect(route('docs.show', [$version]));
        }

        return parent::render($request, $exception);
    }
}
