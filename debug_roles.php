<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

foreach (User::all() as $user) {
    echo "ID: " . $user->id . " | Name: " . $user->name . " | Roles: " . implode(', ', $user->getRoleNames()->toArray()) . "\n";
}
