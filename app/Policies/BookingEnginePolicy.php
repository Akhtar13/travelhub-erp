<?php
namespace App\Policies;
use App\Models\User;
class BookingEnginePolicy { public function manage(User $user): bool { return $user->hasRole('admin') || $user->hasPermissionTo('manage booking engine'); } }
