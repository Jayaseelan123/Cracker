<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'admin@crackerstore.com';
$user = User::where('email', $email)->first();
if (! $user) {
    echo "User $email not found\n";
    exit(1);
}

$user->password = Hash::make('password');
if (! isset($user->is_admin)) {
    // if column doesn't exist, add attribute (will be ignored by DB)
    echo "Warning: 'is_admin' attribute not present on model. Check migration.\n";
}
$user->is_admin = 1;
$user->save();

echo "Updated $email: set password to 'password' and is_admin=1\n";
