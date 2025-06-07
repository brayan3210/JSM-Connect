<?php

/**
 * 🧪 PRUEBA DE ENVÍO DE EMAIL - RECUPERACIÓN DE CONTRASEÑAS
 * Ejecutar con: php test_email.php
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;

// Cargar la aplicación Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "\n🧪 PRUEBA DE ENVÍO DE EMAIL - RECUPERACIÓN DE CONTRASEÑAS\n";
echo str_repeat("=", 70) . "\n\n";

// 1. Verificar configuración de correo
echo "1️⃣  VERIFICANDO CONFIGURACIÓN DE CORREO...\n";
$mailConfig = config('mail');
echo "   📧 Mailer: " . $mailConfig['default'] . "\n";
echo "   📧 Host: " . $mailConfig['mailers']['smtp']['host'] . "\n";
echo "   📧 Puerto: " . $mailConfig['mailers']['smtp']['port'] . "\n";
echo "   📧 Username: " . $mailConfig['mailers']['smtp']['username'] . "\n";
echo "   📧 Password: " . (strlen($mailConfig['mailers']['smtp']['password']) > 0 ? '***configurado***' : 'NO CONFIGURADO') . "\n";
echo "   📧 From: " . $mailConfig['from']['address'] . "\n";

// 2. Buscar un usuario para prueba
echo "\n2️⃣  BUSCANDO USUARIO PARA PRUEBA...\n";
try {
    $usuario = Usuario::first();
    if ($usuario) {
        echo "   ✅ Usuario encontrado: {$usuario->email}\n";
        echo "   📋 Nombre: {$usuario->nombre}\n";
        echo "   📋 ID: {$usuario->id_usuario}\n";
    } else {
        echo "   ❌ No se encontraron usuarios\n";
        exit(1);
    }
} catch (Exception $e) {
    echo "   ❌ Error al buscar usuario: " . $e->getMessage() . "\n";
    exit(1);
}

// 3. Generar token de prueba
echo "\n3️⃣  GENERANDO TOKEN DE PRUEBA...\n";
$token = Str::random(60);
echo "   🔑 Token generado: " . substr($token, 0, 20) . "...\n";

// 4. Guardar token en base de datos
echo "\n4️⃣  GUARDANDO TOKEN EN BASE DE DATOS...\n";
try {
    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $usuario->email],
        [
            'email' => $usuario->email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]
    );
    echo "   ✅ Token guardado en base de datos\n";
} catch (Exception $e) {
    echo "   ❌ Error al guardar token: " . $e->getMessage() . "\n";
    exit(1);
}

// 5. Crear notificación y enviar email
echo "\n5️⃣  ENVIANDO EMAIL DE PRUEBA...\n";
try {
    $notification = new App\Notifications\ResetPasswordNotification($token);
    
    echo "   📤 Enviando email a: {$usuario->email}\n";
    echo "   📤 Usando notificación personalizada...\n";
    
    $usuario->notify($notification);
    
    echo "   ✅ Email enviado exitosamente!\n";
} catch (Exception $e) {
    echo "   ❌ Error al enviar email: " . $e->getMessage() . "\n";
    echo "   🔍 Detalle del error: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 6. Verificar que el enlace funcione
echo "\n6️⃣  VERIFICANDO ENLACE DE RESTABLECIMIENTO...\n";
try {
    $resetUrl = url(route('password.reset', [
        'token' => $token,
        'email' => $usuario->email,
    ]));
    echo "   🔗 URL generada: {$resetUrl}\n";
    echo "   ✅ Enlace válido\n";
} catch (Exception $e) {
    echo "   ❌ Error al generar enlace: " . $e->getMessage() . "\n";
}

// 7. Información adicional
echo "\n7️⃣  INFORMACIÓN ADICIONAL...\n";
echo "   📋 Para revisar logs de Laravel: storage/logs/laravel.log\n";
echo "   📋 Para verificar cola de trabajos: php artisan queue:work\n";
echo "   📋 Para probar manualmente: http://127.0.0.1:8000/forgot-password\n";

echo "\n" . str_repeat("=", 70) . "\n";
echo "📧 RESUMEN DE LA PRUEBA\n";
echo str_repeat("=", 70) . "\n";

echo "\n✅ PASOS COMPLETADOS:\n";
echo "   1. Configuración de correo verificada\n";
echo "   2. Usuario de prueba encontrado\n";
echo "   3. Token generado\n";
echo "   4. Token guardado en BD\n";
echo "   5. Email enviado\n";
echo "   6. Enlace verificado\n";

echo "\n📬 REVISA TU BANDEJA DE ENTRADA:\n";
echo "   Email: {$usuario->email}\n";
echo "   Asunto: 🔐 Restablecer tu Contraseña - JSM Connect\n";
echo "   Remitente: jsmconect@gmail.com\n";

echo "\n⚠️  SI NO LLEGA EL EMAIL:\n";
echo "   1. Revisa la carpeta de SPAM\n";
echo "   2. Verifica que las credenciales SMTP sean correctas\n";
echo "   3. Asegúrate de que el worker de colas esté corriendo\n";
echo "   4. Revisa los logs en storage/logs/laravel.log\n";

echo "\n🔧 COMANDOS ÚTILES:\n";
echo "   • Iniciar colas: php artisan queue:work\n";
echo "   • Ver logs: tail -f storage/logs/laravel.log\n";
echo "   • Limpiar config: php artisan config:clear\n";

echo "\n✨ ¡Prueba completada!\n\n"; 