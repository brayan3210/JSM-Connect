<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Solo registrar para usuarios autenticados
        if (Auth::check()) {
            $user = Auth::user();
            
            // VERIFICAR INTENTOS DE ACCESO NO AUTORIZADO PRIMERO
            $accesoNoAutorizado = $this->verificarAccesoNoAutorizado($request, $response);
            if ($accesoNoAutorizado) {
                Log::crearLog(
                    $user->id_usuario,
                    $accesoNoAutorizado['accion'],
                    $accesoNoAutorizado['descripcion'],
                    'warning',
                    ['url' => $request->getRequestUri(), 'codigo_respuesta' => $response->getStatusCode()]
                );
                return $response;
            }
            
            // Determinar el tipo de acción basado en la ruta y método
            $accion = $this->determinarAccion($request);
            
            // Solo registrar ciertas acciones importantes
            if ($accion) {
                Log::crearLog(
                    $user->id_usuario,
                    $accion,
                    $this->generarDescripcion($request, $accion),
                    $this->determinarTipo($response->getStatusCode()),
                    $this->obtenerParametrosRelevantes($request)
                );
            }
        }

        return $response;
    }

    /**
     * Verificar si es un intento de acceso no autorizado
     */
    private function verificarAccesoNoAutorizado(Request $request, $response)
    {
        $user = Auth::user();
        $uri = $request->getRequestUri();
        $statusCode = $response->getStatusCode();
        
        // Si es un usuario normal intentando acceder a rutas de admin
        if (!$user->es_admin && str_contains($uri, '/admin')) {
            return [
                'accion' => 'Intento de acceso a página restringida',
                'descripcion' => "Usuario sin privilegios intentó acceder a: $uri (HTTP $statusCode)"
            ];
        }
        
        // Si la respuesta es 403 (Forbidden)
        if ($statusCode == 403) {
            return [
                'accion' => 'Acceso denegado por permisos',
                'descripcion' => "Acceso denegado a: $uri (HTTP 403 - Forbidden)"
            ];
        }
        
        // Si la respuesta es 401 (Unauthorized) 
        if ($statusCode == 401) {
            return [
                'accion' => 'Intento de acceso sin autenticación',
                'descripcion' => "Intento de acceso sin autenticación válida a: $uri (HTTP 401)"
            ];
        }
        
        return null;
    }

    /**
     * Determinar el tipo de acción basado en la ruta y método HTTP
     */
    private function determinarAccion(Request $request)
    {
        $route = $request->route();
        $method = $request->method();
        $routeName = $route ? $route->getName() : null;
        $uri = $request->getRequestUri();

        // Mapear rutas específicas a acciones detalladas
        $acciones = [
            // Autenticación
            'login' => 'Inicio de sesión',
            'logout' => 'Cierre de sesión',
            'register' => 'Registro de nuevo usuario',
            
            // Dashboard principal
            'dashboard' => 'Acceso al dashboard principal',
            
            // Búsqueda y exploración
            'buscar' => 'Búsqueda de servicios y profesionales',
            'servicios.todos' => 'Exploración de todos los servicios',
            'usuarios.show' => 'Visualización de perfil público de usuario',
            
            // Perfil de usuario
            'perfil.show' => 'Visualización de perfil personal',
            'perfil.edit' => 'Acceso a edición de perfil',
            'perfil.update' => 'Actualización de datos del perfil',
            'perfil.password' => 'Cambio de contraseña',
            'perfil.preferencias' => 'Gestión de preferencias de usuario',
            'perfil.preferencias.update' => 'Actualización de preferencias',
            'perfil.especialidades' => 'Gestión de especialidades profesionales',
            'perfil.especialidades.update' => 'Actualización de especialidades',
            'perfil.descargar' => 'Descarga de información personal',
            'perfil.desactivar' => 'Desactivación de cuenta',
            
            // Servicios
            'servicios.index' => 'Exploración de servicios disponibles',
            'servicios.create' => 'Acceso a formulario de creación de servicio',
            'servicios.store' => 'Publicación de nuevo servicio',
            'servicios.show' => 'Visualización de detalle de servicio',
            'servicios.edit' => 'Acceso a edición de servicio',
            'servicios.update' => 'Actualización de servicio',
            'servicios.destroy' => 'Eliminación de servicio',
            'servicios.categoria' => 'Exploración de servicios por categoría',
            
            // Solicitudes
            'solicitudes.index' => 'Visualización del centro de solicitudes',
            'solicitudes.store' => 'Creación de nueva solicitud de servicio',
            'solicitudes.show' => 'Visualización de detalle de solicitud',
            'solicitudes.estado' => 'Cambio de estado de solicitud',
            'solicitudes.recibidas' => 'Acceso a solicitudes recibidas',
            'solicitudes.enviadas' => 'Acceso a solicitudes enviadas',
            'solicitudes.valorar' => 'Valoración de servicio completado',
            
            // Mensajes
            'mensajes.index' => 'Acceso a centro de mensajes',
            'mensajes.store' => 'Envío de nuevo mensaje',
            'mensajes.show' => 'Lectura de mensaje',
            'mensajes.conversacion' => 'Acceso a conversación privada',
            'mensajes.enviados' => 'Revisión de mensajes enviados',
            'mensajes.recibidos' => 'Revisión de mensajes recibidos',
            'mensajes.marcar-leido' => 'Marcado de mensaje como leído',
            
            // Onboarding
            'onboarding.preferences' => 'Configuración inicial de preferencias',
            'onboarding.interests' => 'Selección de intereses iniciales',
            'onboarding.specialties' => 'Configuración de especialidades',
            
            // === PANEL DE ADMINISTRACIÓN ===
            // Dashboard admin
            'admin.dashboard' => 'Acceso al panel de administración principal',
            
            // Gestión de usuarios
            'admin.usuarios.index' => 'Acceso a gestión de usuarios',
            'admin.usuarios.show' => 'Visualización de perfil de usuario (Admin)',
            'admin.usuarios.edit' => 'Acceso a edición de usuario (Admin)',
            'admin.usuarios.update' => 'Actualización de datos de usuario (Admin)',
            'admin.usuarios.destroy' => 'Eliminación de usuario (Admin)',
            'admin.usuarios.activar' => 'Activación de usuario (Admin)',
            'admin.usuarios.desactivar' => 'Desactivación de usuario (Admin)',
            
            // Gestión de categorías
            'admin.categorias.index' => 'Acceso a gestión de categorías',
            'admin.categorias.create' => 'Acceso a creación de categoría',
            'admin.categorias.store' => 'Creación de nueva categoría',
            'admin.categorias.edit' => 'Acceso a edición de categoría',
            'admin.categorias.update' => 'Actualización de categoría',
            'admin.categorias.destroy' => 'Eliminación de categoría',
            'admin.categorias.activar' => 'Activación de categoría (Admin)',
            'admin.categorias.desactivar' => 'Desactivación de categoría (Admin)',
            
            // Estadísticas detalladas
            'admin.estadisticas.index' => 'Acceso a resumen general de estadísticas',
            'admin.estadisticas.usuarios' => 'Acceso a estadísticas de usuarios',
            'admin.estadisticas.servicios' => 'Acceso a estadísticas de servicios',
            'admin.estadisticas.categorias' => 'Acceso a estadísticas por categorías',
            'admin.estadisticas.profesiones' => 'Acceso a estadísticas por profesiones',
            'admin.estadisticas.genero' => 'Acceso a estadísticas por género',
            
            // Logs del sistema
            'admin.logs.index' => 'Acceso a logs del sistema',
            'admin.logs.show' => 'Visualización de detalle de log',
            'admin.logs.export' => 'Exportación de logs a PDF',
            'admin.logs.limpiar' => 'Limpieza de logs del sistema',
        ];

        // Verificar si tenemos una acción específica mapeada
        if ($routeName && isset($acciones[$routeName])) {
            return $acciones[$routeName];
        }

        // Verificaciones específicas por URI para casos no mapeados
        if (str_contains($uri, '/buscar')) {
            if ($request->filled('q') || $request->filled('categoria') || $request->filled('ubicacion')) {
                return 'Búsqueda activa de servicios con filtros';
            }
            return 'Acceso a página de búsqueda';
        }

        if (str_contains($uri, '/servicios/categoria/')) {
            $categoria = basename($uri);
            return "Exploración de servicios en categoría: $categoria";
        }

        if (str_contains($uri, '/usuarios/') && $method === 'GET') {
            return 'Visualización de perfil público de profesional';
        }

        // Acciones basadas en URI para rutas que no tengan nombre específico
        if (str_contains($uri, '/admin/')) {
            return $this->determinarAccionAdmin($uri, $method);
        }

        // Acciones de autenticación por método y URI
        if ($method === 'POST' && str_contains($uri, 'login')) {
            return 'Procesamiento de inicio de sesión';
        }

        if ($method === 'POST' && str_contains($uri, 'logout')) {
            return 'Procesamiento de cierre de sesión';
        }

        if ($method === 'GET' && str_contains($uri, 'login')) {
            return 'Acceso a página de inicio de sesión';
        }

        if ($method === 'GET' && str_contains($uri, 'register')) {
            return 'Acceso a página de registro';
        }

        // Acciones específicas por método HTTP
        if ($method === 'POST') {
            return $this->determinarAccionPorPOST($uri);
        }

        if ($method === 'PUT' || $method === 'PATCH') {
            return $this->determinarAccionPorPUT($uri);
        }

        if ($method === 'DELETE') {
            return $this->determinarAccionPorDELETE($uri);
        }

        // Navegación general
        if ($method === 'GET') {
            return $this->determinarAccionPorGET($uri);
        }

        return null; // No registrar esta acción
    }

    /**
     * Determinar acciones específicas del panel de administración
     */
    private function determinarAccionAdmin($uri, $method)
    {
        if (str_contains($uri, '/admin/dashboard')) {
            return 'Navegación en dashboard de administración';
        }
        
        if (str_contains($uri, '/admin/usuarios')) {
            if ($method === 'GET') return 'Exploración de usuarios en administración';
            if ($method === 'POST') return 'Operación en gestión de usuarios';
        }
        
        if (str_contains($uri, '/admin/categorias')) {
            if ($method === 'GET') return 'Exploración de categorías en administración';
            if ($method === 'POST') return 'Operación en gestión de categorías';
        }
        
        if (str_contains($uri, '/admin/estadisticas')) {
            if (str_contains($uri, '/usuarios')) return 'Consulta de estadísticas de usuarios';
            if (str_contains($uri, '/servicios')) return 'Consulta de estadísticas de servicios';
            if (str_contains($uri, '/categorias')) return 'Consulta de estadísticas por categorías';
            if (str_contains($uri, '/profesiones')) return 'Consulta de estadísticas por profesiones';
            if (str_contains($uri, '/genero')) return 'Consulta de estadísticas por género';
            return 'Consulta de estadísticas del sistema';
        }
        
        if (str_contains($uri, '/admin/logs')) {
            return 'Consulta de logs del sistema';
        }

        return 'Actividad administrativa';
    }

    /**
     * Determinar acciones por método POST
     */
    private function determinarAccionPorPOST($uri)
    {
        if (str_contains($uri, '/servicios')) {
            return 'Operación en servicios (creación/búsqueda)';
        }
        
        if (str_contains($uri, '/solicitudes')) {
            return 'Creación de solicitud de servicio';
        }
        
        if (str_contains($uri, '/mensajes')) {
            return 'Envío de mensaje';
        }
        
        if (str_contains($uri, '/perfil')) {
            return 'Actualización de información del perfil';
        }

        if (str_contains($uri, '/onboarding')) {
            return 'Configuración inicial de cuenta';
        }

        return 'Operación de creación';
    }

    /**
     * Determinar acciones por método PUT/PATCH
     */
    private function determinarAccionPorPUT($uri)
    {
        if (str_contains($uri, '/servicios')) {
            return 'Actualización de servicio';
        }
        
        if (str_contains($uri, '/perfil')) {
            return 'Modificación de perfil';
        }
        
        if (str_contains($uri, '/usuarios')) {
            return 'Actualización de datos de usuario';
        }

        if (str_contains($uri, '/solicitudes') && str_contains($uri, '/estado')) {
            return 'Cambio de estado de solicitud';
        }

        return 'Operación de actualización';
    }

    /**
     * Determinar acciones por método DELETE
     */
    private function determinarAccionPorDELETE($uri)
    {
        if (str_contains($uri, '/servicios')) {
            return 'Eliminación de servicio';
        }
        
        if (str_contains($uri, '/usuarios')) {
            return 'Eliminación de usuario';
        }
        
        if (str_contains($uri, '/categorias')) {
            return 'Eliminación de categoría';
        }

        if (str_contains($uri, '/preferencias')) {
            return 'Eliminación de preferencia';
        }

        if (str_contains($uri, '/especialidades')) {
            return 'Eliminación de especialidad';
        }

        return 'Operación de eliminación';
    }

    /**
     * Determinar acciones por método GET para casos específicos
     */
    private function determinarAccionPorGET($uri)
    {
        if ($uri === '/' || $uri === '') {
            return 'Acceso a página de inicio';
        }

        if (str_contains($uri, '/forgot-password')) {
            return 'Acceso a recuperación de contraseña';
        }

        if (str_contains($uri, '/reset-password')) {
            return 'Acceso a restablecimiento de contraseña';
        }

        return null; // No registrar navegación general
    }

    /**
     * Generar descripción detallada de la acción
     */
    private function generarDescripcion(Request $request, $accion)
    {
        $route = $request->route();
        $parametros = $route ? $route->parameters() : [];
        $uri = $request->getRequestUri();
        
        $descripcion = $accion;
        
        // Agregar información específica para búsquedas
        if (str_contains($accion, 'búsqueda') || str_contains($accion, 'Búsqueda')) {
            $filtros = [];
            if ($request->filled('q')) $filtros[] = "término: '{$request->q}'";
            if ($request->filled('categoria')) $filtros[] = "categoría: {$request->categoria}";
            if ($request->filled('ubicacion')) $filtros[] = "ubicación: '{$request->ubicacion}'";
            
            if (!empty($filtros)) {
                $descripcion .= " - Filtros: " . implode(', ', $filtros);
            }
        }
        
        // Agregar información de contexto según la acción
        if (str_contains($accion, 'estadísticas')) {
            $descripcion .= " - Sección: " . basename($uri);
        }
        
        if (!empty($parametros)) {
            $detalles = [];
            foreach ($parametros as $key => $value) {
                if (is_numeric($value)) {
                    $detalles[] = "{$key}: {$value}";
                }
            }
            if (!empty($detalles)) {
                $descripcion .= " (" . implode(', ', $detalles) . ")";
            }
        }

        // Agregar información adicional para administradores
        if (Auth::check() && Auth::user()->es_admin) {
            $descripcion = "[ADMIN] " . $descripcion;
        }

        return $descripcion;
    }

    /**
     * Determinar el tipo de log basado en el código de respuesta
     */
    private function determinarTipo($statusCode)
    {
        if ($statusCode >= 200 && $statusCode < 300) {
            return 'success';
        } elseif ($statusCode >= 400 && $statusCode < 500) {
            return 'warning';
        } elseif ($statusCode >= 500) {
            return 'error';
        }
        
        return 'info';
    }

    /**
     * Obtener parámetros relevantes para el log
     */
    private function obtenerParametrosRelevantes(Request $request)
    {
        $parametros = [];
        
        // No incluir datos sensibles como passwords
        $excluir = ['password', 'password_confirmation', '_token', '_method'];
        
        foreach ($request->all() as $key => $value) {
            if (!in_array($key, $excluir) && !is_file($value)) {
                $parametros[$key] = is_string($value) ? substr($value, 0, 255) : $value;
            }
        }
        
        return empty($parametros) ? null : $parametros;
    }
} 