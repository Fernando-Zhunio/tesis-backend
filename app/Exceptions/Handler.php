<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
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
    public function register()
    {
        // $this->reportable(function (Throwable $e) {
        //     return response()->json([
        //         'message' => $e->getMessage(),
        //         'code' => $e->getCode(),
        //     ], $e->getCode());
        // });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->is('api/*') || $request->wantsJson()) {
                $errors_string = '';
                foreach ($e->errors() as $error) {
                    $errors_string .= $error[0] . "\n";
                }
                return response()->json([
                    'success' => false,
                    'errors'=> $errors_string,
                ], 422);
            }
        });
    }
}
