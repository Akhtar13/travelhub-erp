<?php
namespace App\Policies;
use App\Models\User;
class AgentPolicy { public function manage(User $user): bool { return method_exists($user,'hasPermission') ? $user->hasPermission('manage agents') : true; } }
