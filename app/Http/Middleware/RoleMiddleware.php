<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            \Log::info('RoleMiddleware: User not authenticated', ['url' => $request->url()]);
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Log middleware execution
        \Log::info('RoleMiddleware', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'required_role' => $role,
            'url' => $request->url()
        ]);
        
        // Check role using the role field
        if ($user->role !== $role) {
            \Log::warning('RoleMiddleware: Role mismatch', [
                'user_role' => $user->role,
                'required_role' => $role
            ]);
            abort(403, "Unauthorized access. {$role} role required.");
        }

        return $next($request);
    }
}
