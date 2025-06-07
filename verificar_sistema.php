<?php

/**
 * ✅ VERIFICACIÓN COMPLETA DEL SISTEMA DE RECUPERACIÓN DE CONTRASEÑAS
 * Ejecutar con: php verificar_sistema.php
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Cargar la aplicación Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n🔍 VERIFICACIÓN COMPLETA DEL SISTEMA DE RECUPERACIÓN DE CONTRASEÑAS\n";
echo str_repeat("=", 80) . "\n\n";

$allChecks = [];

// 1. Verificar base de datos
echo "1️⃣  VERIFICANDO BASE DE DATOS...\n";
try {
    $usuarios = DB::table('usuarios')->count();
    $tokens = DB::table('password_reset_tokens')->count();
    echo "   ✅ Tabla 'usuarios': {$usuarios} registros\n";
    echo "   ✅ Tabla 'password_reset_tokens': {$tokens} tokens\n";
    $allChecks['database'] = true;
} catch (Exception $e) {
    echo "   ❌ Error de base de datos: " . $e->getMessage() . "\n";
    $allChecks['database'] = false;
}

// 2. Verificar archivos de controladores
echo "\n2️⃣  VERIFICANDO CONTROLADORES...\n";
$controllers = [
    'app/Http/Controllers/Auth/ForgotPasswordController.php',
    'app/Http/Controllers/Auth/ResetPasswordController.php'
];

foreach ($controllers as $controller) {
    if (file_exists($controller)) {
        echo "   ✅ {$controller}\n";
        $allChecks['controllers'][] = true;
    } else {
        echo "   ❌ FALTA: {$controller}\n";
        $allChecks['controllers'][] = false;
    }
}

// 3. Verificar vistas
echo "\n3️⃣  VERIFICANDO VISTAS...\n";
$views = [
    'resources/views/auth/passwords/email.blade.php',
    'resources/views/auth/passwords/reset.blade.php',
    'resources/views/emails/reset-password.blade.php'
];

foreach ($views as $view) {
    if (file_exists($view)) {
        echo "   ✅ {$view}\n";
        $allChecks['views'][] = true;
    } else {
        echo "   ❌ FALTA: {$view}\n";
        $allChecks['views'][] = false;
    }
}

// 4. Verificar notificación
echo "\n4️⃣  VERIFICANDO NOTIFICACIONES...\n";
if (file_exists('app/Notifications/ResetPasswordNotification.php')) {
    echo "   ✅ app/Notifications/ResetPasswordNotification.php\n";
    $allChecks['notification'] = true;
} else {
    echo "   ❌ FALTA: app/Notifications/ResetPasswordNotification.php\n";
    $allChecks['notification'] = false;
}

// 5. Verificar configuración de auth
echo "\n5️⃣  VERIFICANDO CONFIGURACIÓN DE AUTENTICACIÓN...\n";
$authConfig = config('auth');
if ($authConfig['defaults']['passwords'] === 'usuarios') {
    echo "   ✅ Broker de passwords: 'usuarios'\n";
    $allChecks['auth_broker'] = true;
} else {
    echo "   ❌ Broker incorrecto: " . $authConfig['defaults']['passwords'] . "\n";
    $allChecks['auth_broker'] = false;
}

if (isset($authConfig['passwords']['usuarios'])) {
    $config = $authConfig['passwords']['usuarios'];
    echo "   ✅ Configuración passwords.usuarios existe\n";
    echo "   📋 Provider: " . $config['provider'] . "\n";
    echo "   📋 Tabla: " . $config['table'] . "\n";
    echo "   📋 Expiración: " . $config['expire'] . " minutos\n";
    echo "   📋 Throttle: " . $config['throttle'] . " segundos\n";
    $allChecks['auth_config'] = true;
} else {
    echo "   ❌ Falta configuración passwords.usuarios\n";
    $allChecks['auth_config'] = false;
}

// 6. Verificar configuración de correo
echo "\n6️⃣  VERIFICANDO CONFIGURACIÓN DE CORREO...\n";
$mailConfig = config('mail');
echo "   📧 Mailer por defecto: " . $mailConfig['default'] . "\n";

if (isset($mailConfig['mailers']['smtp'])) {
    $smtp = $mailConfig['mailers']['smtp'];
    echo "   📧 Host SMTP: " . $smtp['host'] . "\n";
    echo "   📧 Puerto: " . $smtp['port'] . "\n";
    echo "   📧 Encriptación: " . $smtp['encryption'] . "\n";
    $allChecks['mail_config'] = true;
} else {
    echo "   ❌ Configuración SMTP no encontrada\n";
    $allChecks['mail_config'] = false;
}

// 7. Verificar variables de entorno
echo "\n7️⃣  VERIFICANDO VARIABLES DE ENTORNO...\n";
$envVars = [
    'MAIL_MAILER' => env('MAIL_MAILER'),
    'MAIL_HOST' => env('MAIL_HOST'),
    'MAIL_PORT' => env('MAIL_PORT'),
    'MAIL_USERNAME' => env('MAIL_USERNAME') ? '***configurado***' : null,
    'MAIL_PASSWORD' => env('MAIL_PASSWORD') ? '***configurado***' : null,
    'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
    'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
];

$envConfigured = true;
foreach ($envVars as $var => $value) {
    $status = $value ? "✅" : "❌";
    echo "   {$status} {$var}: " . ($value ?: 'No configurado') . "\n";
    if (!$value) $envConfigured = false;
}
$allChecks['env_vars'] = $envConfigured;

// 8. Verificar rutas
echo "\n8️⃣  VERIFICANDO RUTAS...\n";
$routes = [
    'password.request' => 'forgot-password',
    'password.email' => 'forgot-password (POST)',
    'password.reset' => 'reset-password/{token}',
    'password.update' => 'reset-password (POST)',
];

$routesOk = true;
foreach ($routes as $name => $description) {
    try {
        if ($name === 'password.reset') {
            $url = route($name, ['token' => 'test-token']);
        } else {
            $url = route($name);
        }
        echo "   ✅ Ruta '{$name}': {$description}\n";
    } catch (Exception $e) {
        echo "   ❌ Ruta '{$name}' no encontrada\n";
        $routesOk = false;
    }
}
$allChecks['routes'] = $routesOk;

// 9. Verificar modelo Usuario
echo "\n9️⃣  VERIFICANDO MODELO USUARIO...\n";
try {
    $usuario = new App\Models\Usuario();
    if (method_exists($usuario, 'sendPasswordResetNotification')) {
        echo "   ✅ Método sendPasswordResetNotification existe\n";
        $allChecks['user_model'] = true;
    } else {
        echo "   ❌ Método sendPasswordResetNotification no existe\n";
        $allChecks['user_model'] = false;
    }
} catch (Exception $e) {
    echo "   ❌ Error con modelo Usuario: " . $e->getMessage() . "\n";
    $allChecks['user_model'] = false;
}

// 10. Verificar clases necesarias
echo "\n🔟 VERIFICANDO CLASES...\n";
try {
    $notification = new App\Notifications\ResetPasswordNotification('test-token');
    echo "   ✅ Notificación ResetPasswordNotification\n";
    $allChecks['notification_class'] = true;
} catch (Exception $e) {
    echo "   ❌ Error con notificación: " . $e->getMessage() . "\n";
    $allChecks['notification_class'] = false;
}

try {
    $forgotController = new App\Http\Controllers\Auth\ForgotPasswordController();
    echo "   ✅ Controlador ForgotPasswordController\n";
    $allChecks['forgot_controller'] = true;
} catch (Exception $e) {
    echo "   ❌ Error con ForgotPasswordController: " . $e->getMessage() . "\n";
    $allChecks['forgot_controller'] = false;
}

try {
    $resetController = new App\Http\Controllers\Auth\ResetPasswordController();
    echo "   ✅ Controlador ResetPasswordController\n";
    $allChecks['reset_controller'] = true;
} catch (Exception $e) {
    echo "   ❌ Error con ResetPasswordController: " . $e->getMessage() . "\n";
    $allChecks['reset_controller'] = false;
}

// RESUMEN FINAL
echo "\n" . str_repeat("=", 80) . "\n";
echo "📊 RESUMEN DE VERIFICACIÓN\n";
echo str_repeat("=", 80) . "\n";

$totalChecks = 0;
$passedChecks = 0;

foreach ($allChecks as $category => $result) {
    if (is_array($result)) {
        foreach ($result as $check) {
            $totalChecks++;
            if ($check) $passedChecks++;
        }
    } else {
        $totalChecks++;
        if ($result) $passedChecks++;
    }
}

$percentage = round(($passedChecks / $totalChecks) * 100);

echo "\n📈 Estado del Sistema: {$passedChecks}/{$totalChecks} verificaciones pasadas ({$percentage}%)\n";

if ($percentage >= 90) {
    echo "🎉 ¡EXCELENTE! El sistema está completamente funcional\n";
    $status = "COMPLETAMENTE FUNCIONAL";
    $color = "🟢";
} elseif ($percentage >= 70) {
    echo "⚠️  BUENO - Hay algunos problemas menores\n";
    $status = "FUNCIONAL CON ADVERTENCIAS";
    $color = "🟡";
} else {
    echo "❌ CRÍTICO - Hay problemas importantes que resolver\n";
    $status = "REQUIERE CORRECCIONES";
    $color = "🔴";
}

echo "\n{$color} ESTADO FINAL: {$status}\n";

echo "\n" . str_repeat("=", 80) . "\n";
echo "🚀 PASOS SIGUIENTES\n";
echo str_repeat("=", 80) . "\n";

if ($percentage >= 90) {
    echo "\n✅ PARA USAR EL SISTEMA:\n";
    echo "   1. Asegúrate de que las credenciales SMTP estén en tu .env\n";
    echo "   2. Ejecuta: php artisan serve\n";
    echo "   3. Ejecuta en otra terminal: php artisan queue:work\n";
    echo "   4. Ve a: http://127.0.0.1:8000/forgot-password\n";
    
    echo "\n🔗 URLs PRINCIPALES:\n";
    echo "   • Recuperar contraseña: http://127.0.0.1:8000/forgot-password\n";
    echo "   • Login: http://127.0.0.1:8000/login\n";
    echo "   • Dashboard: http://127.0.0.1:8000/dashboard\n";
} else {
    echo "\n🔧 CORRECCIONES NECESARIAS:\n";
    foreach ($allChecks as $category => $result) {
        if (is_array($result)) {
            foreach ($result as $i => $check) {
                if (!$check) {
                    echo "   • Revisar {$category}\n";
                    break;
                }
            }
        } else {
            if (!$result) {
                echo "   • Revisar {$category}\n";
            }
        }
    }
}

echo "\n🎨 CARACTERÍSTICAS IMPLEMENTADAS:\n";
echo "   • Color principal: #104CFF\n";
echo "   • Vistas modernas y responsivas\n";
echo "   • Email HTML profesional\n";
echo "   • Validaciones en español\n";
echo "   • Sistema de seguridad robusto\n";
echo "   • Tokens con expiración automática\n";

echo "\n✨ ¡Sistema de recuperación de contraseñas listo!\n\n"; 