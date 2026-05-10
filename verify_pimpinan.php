<?php

use Illuminate\Support\Facades\DB;

require __DIR__ . '/bootstrap/app.php';

$app = app();

// Check roles
echo "=== ROLES IN DATABASE ===\n";
$roles = DB::table('roles')->select('id', 'name', 'guard_name')->get();
foreach ($roles as $role) {
    echo "ID: {$role->id}, Name: {$role->name}, Guard: {$role->guard_name}\n";
}

// Check users with roles
echo "\n=== USERS WITH PIMPINAN ROLE ===\n";
$users = DB::table('users')
    ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
    ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
    ->where('roles.name', 'Pimpinan')
    ->select('users.id', 'users.name', 'users.email', 'roles.name as role')
    ->get();

foreach ($users as $user) {
    echo "ID: {$user->id}, Name: {$user->name}, Email: {$user->email}, Role: {$user->role}\n";
}

echo "\n=== VERIFICATION COMPLETE ===\n";
