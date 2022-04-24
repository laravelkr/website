<?php

namespace App\Exceptions;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Sentry\State\Scope;
use Throwable;

use function Sentry\configureScope;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        FileNotFoundException::class
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if ($this->shouldReport($e) && app()->bound('sentry')) {
                configureScope(function (Scope $scope): void {
                    $referer = request()->headers->get('referer');
                    if ($referer) {
                        $scope->setTag('referer', $referer);
                    }
                });
                app('sentry')->captureException($e);
            }
        });

        $this->renderable(function (FileNotFoundException $exception, Request $request) {
            $version = $request->route()?->parameter('version');
            $doc = $request->route()?->parameter('doc');
            toastr()->error($doc."는 ".$version." 버전에 존재하지 않는 문서입니다", "", [
                "positionClass" => "toast-top-full-width",
            ]);

            return redirect(route('docs.show', [$version]));
        });
    }


}
