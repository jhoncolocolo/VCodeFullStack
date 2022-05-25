<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {   
        if( $request->is('api/*')){

            if ($exception instanceof ModelNotFoundException ) {
                
                $model = strtolower(class_basename($exception->getModel()));
                      
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }
            if ($exception instanceof NotFoundHttpException) {
                if($request->is('api/*') ){
                    return response()->json([
                        'message' => ($exception->getMessage() ?? 'Resource not found')
                    ], 404);
                }              
            }

            if ($exception instanceof HttpException) {
                if($request->is('api/*') ){
                    return response()->json([
                        'message' => ($exception->getMessage() ?? 'Error In the Request')
                    ], $exception->getStatusCode());
                }              
            }

            if($exception->getMessage() == "Call to a member function fill() on null"){
                return response()->json([
                    'message' => 'Model not found'
                ], 404);
            }

        }
    }
}
