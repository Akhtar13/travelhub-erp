<?php
namespace App\Policies;
use App\Models\User;
class CheckInPolicy { public function manage(User $user): bool { return method_exists($user,'hasPermission') ? $user->hasPermission('manage check-ins') : true; } }
