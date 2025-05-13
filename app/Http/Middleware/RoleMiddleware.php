<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
     public function handle(Request $request, Closure $next, ...$roles)
     {
         if (!Auth::check()) {
             return redirect('/home');
         }
 
         $user = Auth::user();
 
         // Check if user's role is in the allowed roles
         if (in_array($user->role, $roles)) {
             return $next($request);
         }
 
         return abort(403, 'Unauthorized access.');
     }
}
