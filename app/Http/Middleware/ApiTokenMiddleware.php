<?php
namespace App\Http\Middleware;
use App\Models\PersonalAccessToken; use Closure; use Illuminate\Http\Request; use Illuminate\Support\Facades\Hash;
class ApiTokenMiddleware { public function handle(Request $request, Closure $next){ $plain=$request->bearerToken(); abort_unless($plain,401,'Missing bearer token.'); $token=PersonalAccessToken::where('token',hash('sha256',$plain))->first(); abort_unless($token && (!$token->expires_at || $token->expires_at->isFuture()),401,'Invalid bearer token.'); $token->forceFill(['last_used_at'=>now()])->save(); auth()->setUser($token->tokenable); return $next($request); } }
