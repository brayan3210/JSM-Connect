<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Solo trackear GET requests exitosos y páginas específicas
        if ($request->isMethod('GET') && $response->getStatusCode() === 200) {
            $page = $request->path();
            
            // Lista de páginas que queremos trackear
            $pagesToTrack = ['/', 'login', 'register'];
            
            if (in_array($page, $pagesToTrack) || $page === '') {
                try {
                    Visit::registrarVisita($request, $page === '' ? '/' : '/' . $page);
                } catch (\Exception $e) {
                    // En caso de error, continuar sin afectar la experiencia del usuario
                    \Log::error('Error tracking visit: ' . $e->getMessage());
                }
            }
        }

        return $response;
    }
} 