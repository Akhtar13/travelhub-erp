<?php
namespace App\Http\Middleware; use Closure; use Illuminate\Http\Request;
class PermissionMiddleware { public function handle(Request $request, Closure $next, string $permission){ abort_unless($request->user()?->hasPermissionTo($permission) || $request->user()?->hasRole('Super Admin'), 403); return $next($request); } }
