<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Exception $e, Request $request) {
            if ($request->is('api/*')) {
                if ($e instanceof RouteNotFoundException) {
                    return response()->json(['message' => 'Route not found', 'data'=> $request->all(), 'status'=>'error'], 404);
                }
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json(['message' => $e->validator->errors()->first(), 'data'=> $request->all(), 'status'=>'error'], 422);
                }
                if($e instanceof ValidatorException){
                    return response()->json(['message' => $e->getMessageBag()->getMessages(), 'data'=> $request->all(), 'status'=>'error'], 422);
                }

                if ($e instanceof Exception) {
                    return response()->json(['message' => $e->getMessage(), 'data'=> $request->all(), 'status'=>'error'], 422);
                }
            }
        });
    })->create();
