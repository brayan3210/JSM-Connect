<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$admin = \App\Models\Usuario::where('es_admin', true)->first();

if ($admin) {
    echo "Email: " . $admin->email . "\n";
    echo "Nombre: " . $admin->nombre . " " . $admin->apellidos . "\n";
    echo "Activo: " . ($admin->activo ? 'Sí' : 'No') . "\n";
    
    // Resetear contraseña
    $admin->password = bcrypt('admin123');
    $admin->save();
    echo "Contraseña reseteada a: admin123\n";
} else {
    echo "No se encontró administrador\n";
} 