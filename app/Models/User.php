<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'phone', 'avatar', 'status'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function roles(): BelongsToMany { return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')->wherePivot('model_type', self::class); }
    public function permissions(): BelongsToMany { return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id', 'permission_id')->wherePivot('model_type', self::class); }
    public function hasRole(string $role): bool { return $this->roles()->where('name', $role)->exists(); }
    public function hasPermissionTo(string $permission): bool { return $this->permissions()->where('name', $permission)->exists() || $this->roles()->whereHas('permissions', fn($q) => $q->where('name', $permission))->exists(); }
}
