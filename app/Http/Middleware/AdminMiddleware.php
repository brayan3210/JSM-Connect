<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No autenticado'], 401);
            }
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta área.');
        }

        // Verificar si el usuario es administrador
        if (!$request->user()->esAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Acceso denegado. No tienes permisos de administrador.'], 403);
            }
            
            // Para peticiones web, devolver respuesta 403 para que el middleware de logging lo capture
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Acceso denegado'], 403);
            }
            
            // Para peticiones normales, también registramos el intento y luego redirigimos
            return response()->view('errors.403', [
                'message' => 'No tienes permisos para acceder al panel de administración.'
            ], 403);
        }

        return $next($request);
    }
} 