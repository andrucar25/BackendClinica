<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTPacienteMiddleware
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct()
    {
        auth()->shouldUse('api_pacientes');
    }

    public function handle($request, Closure $next)
    {
        try
        {
            JWTAuth::parseToken()->authenticate();
        }
        catch(\Exception $e)
        {
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException)
            {
                return response()->json([
                    'status' => 'token_invalid',
                    'message' => 'Token no válido'
                ], 401);
            }
            else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException)
            {
                return response()->json([
                    'status' => 'token_expired',
                    'message' => 'Token caducado'
                ], 401);
            }
            else if($e instanceof \Tymon\JWTAuth\Exceptions\JWTException)
            {
                return response()->json([
                    'status' => 'token_absent',
                    'message' => 'Token Ausente'
                ], 401);
            }
            else
            {
                return response()->json([
                    'status' => 'token_nofound',
                    'message' => 'Token de autorización no encontrado'
                ], 401);
            }
        }

        return $next($request);
    }
}
