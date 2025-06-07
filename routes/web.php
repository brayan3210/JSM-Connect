<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Admin\CategoriasController;
use App\Http\Controllers\Admin\EstadisticasController;
use App\Http\Controllers\Admin\AdministradoresController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\SolicitudesController;
use App\Http\Controllers\MensajesController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PolicyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta de inicio
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas públicas para políticas
Route::get('/politica-datos', [PolicyController::class, 'showDataPolicy'])->name('policy.data');
Route::get('/politica-datos/descargar', [PolicyController::class, 'downloadDataPolicy'])->name('policy.data.download');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Rutas de onboarding para usuarios recién registrados
Route::middleware(['auth', 'usuario.normal'])->prefix('onboarding')->name('onboarding.')->group(function () {
    Route::get('/preferences', [OnboardingController::class, 'showPreferences'])->name('preferences');
    Route::post('/preferences', [OnboardingController::class, 'storePreferences'])->name('preferences.store');
    
    Route::get('/interests', [OnboardingController::class, 'showInterests'])->name('interests');
    Route::post('/interests', [OnboardingController::class, 'storeInterests'])->name('interests.store');
    
    Route::get('/specialties', [OnboardingController::class, 'showSpecialties'])->name('specialties');
    Route::post('/specialties', [OnboardingController::class, 'storeSpecialties'])->name('specialties.store');
});

// Rutas para usuarios autenticados (no administradores)
Route::middleware(['auth', 'usuario.normal'])->group(function () {
    // Dashboard de usuario
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Perfil de usuario
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.show');
    Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/preferencias', [PerfilController::class, 'showPreferencias'])->name('perfil.preferencias');
    Route::post('/perfil/preferencias', [PerfilController::class, 'updatePreferencias'])->name('perfil.preferencias.update');
    Route::post('/perfil/preferencias/store', [PerfilController::class, 'updatePreferencias'])->name('perfil.preferencias.store');
    Route::delete('/perfil/preferencias/{preferencia}', [PerfilController::class, 'destroyPreferencia'])->name('perfil.preferencias.destroy');
    Route::get('/perfil/especialidades', [PerfilController::class, 'showEspecialidades'])->name('perfil.especialidades');
    Route::post('/perfil/especialidades', [PerfilController::class, 'updateEspecialidades'])->name('perfil.especialidades.update');
    Route::post('/perfil/especialidades/store', [PerfilController::class, 'updateEspecialidades'])->name('perfil.especialidades.store');
    Route::delete('/perfil/especialidades/{especialidad}', [PerfilController::class, 'destroyEspecialidad'])->name('perfil.especialidades.destroy');
    Route::get('/perfil/descargar', [PerfilController::class, 'descargarInformacion'])->name('perfil.descargar');
    Route::post('/perfil/desactivar', [PerfilController::class, 'desactivarCuenta'])->name('perfil.desactivar');
    
    // Servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServiciosController::class, 'create'])->name('servicios.create');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}', [ServiciosController::class, 'show'])->name('servicios.show');
    Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'edit'])->name('servicios.edit');
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{servicio}', [ServiciosController::class, 'destroy'])->name('servicios.destroy');
    Route::get('/servicios/categoria/{categoria}', [ServiciosController::class, 'porCategoria'])->name('servicios.categoria');
    
    // Búsqueda de servicios/profesionales
    Route::get('/buscar', [ServiciosController::class, 'buscar'])->name('buscar');
    Route::get('/usuarios/{usuario}', [ServiciosController::class, 'verUsuario'])->name('usuarios.show');
    Route::get('/servicios/todos', [ServiciosController::class, 'todos'])->name('servicios.todos');
    
    // Solicitudes de servicios
    Route::get('/solicitudes', [SolicitudesController::class, 'index'])->name('solicitudes.index');
    Route::get('/solicitudes/enviadas', [SolicitudesController::class, 'enviadas'])->name('solicitudes.enviadas');
    Route::get('/solicitudes/recibidas', [SolicitudesController::class, 'recibidas'])->name('solicitudes.recibidas');
    Route::post('/solicitudes', [SolicitudesController::class, 'store'])->name('solicitudes.store');
    Route::get('/solicitudes/{solicitud}', [SolicitudesController::class, 'show'])->name('solicitudes.show');
    Route::put('/solicitudes/{solicitud}/estado', [SolicitudesController::class, 'cambiarEstado'])->name('solicitudes.estado');
    Route::post('/solicitudes/{solicitud}/valoracion', [SolicitudesController::class, 'valorar'])->name('solicitudes.valorar');
    
    // Mensajes
    Route::get('/mensajes', [MensajesController::class, 'index'])->name('mensajes.index');
    Route::get('/mensajes/enviados', [MensajesController::class, 'enviados'])->name('mensajes.enviados');
    Route::get('/mensajes/enviados/ajax', [MensajesController::class, 'enviadosAjax'])->name('mensajes.enviados.ajax');
    Route::get('/mensajes/recibidos', [MensajesController::class, 'recibidos'])->name('mensajes.recibidos');
    Route::get('/mensajes/recibidos/ajax', [MensajesController::class, 'recibidosAjax'])->name('mensajes.recibidos.ajax');
    Route::get('/mensajes/conversacion/{usuario}', [MensajesController::class, 'conversacion'])->name('mensajes.conversacion');
    Route::get('/mensajes/conversacion/{usuario}/ajax', [MensajesController::class, 'conversacionAjax'])->name('mensajes.conversacion.ajax');
    Route::post('/mensajes', [MensajesController::class, 'store'])->name('mensajes.store');
    Route::post('/mensajes/ajax', [MensajesController::class, 'storeAjax'])->name('mensajes.store.ajax');
    Route::put('/mensajes/marcar-leido/{mensaje}', [MensajesController::class, 'marcarLeido'])->name('mensajes.marcar-leido');
});

// Rutas para administradores
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard de administrador
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de usuarios
    Route::get('/usuarios', [UsuariosController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{usuario}', [UsuariosController::class, 'show'])->name('usuarios.show');
    Route::get('/usuarios/{usuario}/editar', [UsuariosController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UsuariosController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
    Route::put('/usuarios/{usuario}/activar', [UsuariosController::class, 'activar'])->name('usuarios.activar');
    Route::put('/usuarios/{usuario}/desactivar', [UsuariosController::class, 'desactivar'])->name('usuarios.desactivar');
    
    // Gestión de categorías
    Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');
    Route::get('/categorias/crear', [CategoriasController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriasController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{categoria}/editar', [CategoriasController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{categoria}', [CategoriasController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{categoria}', [CategoriasController::class, 'destroy'])->name('categorias.destroy');
    Route::put('/categorias/{categoria}/desactivar', [CategoriasController::class, 'desactivar'])->name('categorias.desactivar');
    Route::put('/categorias/{categoria}/activar', [CategoriasController::class, 'activar'])->name('categorias.activar');
    
    // Gestión de administradores
    Route::get('/administradores', [AdministradoresController::class, 'index'])->name('administradores.index');
    Route::get('/administradores/crear', [AdministradoresController::class, 'create'])->name('administradores.create');
    Route::post('/administradores', [AdministradoresController::class, 'store'])->name('administradores.store');
    Route::get('/administradores/{administrador}', [AdministradoresController::class, 'show'])->name('administradores.show');
    Route::get('/administradores/{administrador}/editar', [AdministradoresController::class, 'edit'])->name('administradores.edit');
    Route::put('/administradores/{administrador}', [AdministradoresController::class, 'update'])->name('administradores.update');
    Route::put('/administradores/{administrador}/toggle-status', [AdministradoresController::class, 'toggleStatus'])->name('administradores.toggle-status');
    Route::delete('/administradores/{administrador}', [AdministradoresController::class, 'destroy'])->name('administradores.destroy');
    
    // Estadísticas
    Route::get('/estadisticas', [EstadisticasController::class, 'index'])->name('estadisticas.index');
    Route::get('/estadisticas/usuarios', [EstadisticasController::class, 'usuarios'])->name('estadisticas.usuarios');
    Route::get('/estadisticas/genero', [EstadisticasController::class, 'genero'])->name('estadisticas.genero');
    Route::get('/estadisticas/profesiones', [EstadisticasController::class, 'profesiones'])->name('estadisticas.profesiones');
    Route::get('/estadisticas/categorias', [EstadisticasController::class, 'categorias'])->name('estadisticas.categorias');
    Route::get('/estadisticas/servicios', [EstadisticasController::class, 'servicios'])->name('estadisticas.servicios');
    
    // Sistema de Logs
    Route::get('/logs', [\App\Http\Controllers\Admin\LogsController::class, 'index'])->name('logs.index');
    Route::get('/logs/{usuario}', [\App\Http\Controllers\Admin\LogsController::class, 'show'])->name('logs.show');
    Route::get('/logs/{usuario}/export', [\App\Http\Controllers\Admin\LogsController::class, 'exportPdf'])->name('logs.export');
    Route::post('/logs/limpiar', [\App\Http\Controllers\Admin\LogsController::class, 'limpiar'])->name('logs.limpiar');
});
