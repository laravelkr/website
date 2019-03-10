<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {

        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }


        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
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
