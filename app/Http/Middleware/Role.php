<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
        if (!$request->user() || $request->user()->role !== $role) {
            // Redirect based on role
            if ($request->user()->role === 'admin') {
                return redirect('/admin/dashboard'); // admin section
            } elseif ($request->user()->role === 'user') {
                return redirect('/user/dashboard'); // student section
            } 
            
            return redirect('/dashboard'); // fallback
        }


        return $next($request);
    }
}
