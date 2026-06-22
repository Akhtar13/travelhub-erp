<?php
namespace App\Policies;
use App\Models\User;
class ReportPolicy { public function view(User $user): bool { return method_exists($user,'hasPermission') ? $user->hasPermission('view reports') : true; } }
