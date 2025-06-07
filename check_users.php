<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking for users with null created_at...\n";

$nullUsers = \App\Models\Usuario::whereNull('created_at')->count();
echo "Users with null created_at: " . $nullUsers . "\n";

$totalUsers = \App\Models\Usuario::count();
echo "Total users: " . $totalUsers . "\n";

if ($nullUsers > 0) {
    echo "Found users with null created_at. This could cause the format() error.\n";
    
    // Show first 5 users with null created_at
    $users = \App\Models\Usuario::whereNull('created_at')->limit(5)->get();
    foreach ($users as $user) {
        echo "User ID: {$user->id_usuario}, Name: {$user->nombre}, created_at: " . ($user->created_at ?? 'NULL') . "\n";
    }
} else {
    echo "No users with null created_at found.\n";
}

echo "Done!\n"; 