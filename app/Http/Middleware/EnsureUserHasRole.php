<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;

class EnsureUserHasRole
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = auth()->user();
        $userRole = Role::find($user->role_id);
        
        // Debug logging
        \Log::info('Role Middleware Debug', [
            'user_id' => $user->id,
            'user_role_id' => $user->role_id,
            'user_role_name' => $userRole ? $userRole->name : 'null',
            'required_roles' => $roles,
            'current_route' => $request->route()->getName()
        ]);
        
        foreach ($roles as $role) {
            if ($userRole && $userRole->name === $role) {
                return $next($request);
            }
        }

        // Prevent redirect loop to dashboard
        if ($request->route()->getName() === 'dashboard.index' && $userRole && $userRole->name === 'operator') {
            \Log::error('Potential redirect loop detected for operator user');
            return $next($request); // Allow access to prevent loop
        }

        $route = in_array($userRole->name ?? '', ['karyawan', 'guru']) ? 'home.index' : 'dashboard.index';
        return redirect()->route($route)->with('failed', 'Kamu tidak memiliki izin untuk mengakses halaman tersebut.');
    }
}
