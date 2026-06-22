<?php
namespace App\Policies; use App\Models\User;
class RolePolicy { public function before(User $user): ?bool { return $user->hasRole('Super Admin') ? true : null; } public function manage(User $user): bool { return $user->hasPermissionTo('roles.manage'); } }
