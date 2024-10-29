<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RefreshSessionTTL
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
     public function handle(Request $request, Closure $next)
    {
        Log::info('InterceptSessionCookie middleware invoked.');

        // Obtener el ID de la cookie de sesión
        $sessionId = $request->cookie('laravel_session');
        Log::info('Session ID: ' . $sessionId);

        return $next($request);
    }

    

}
