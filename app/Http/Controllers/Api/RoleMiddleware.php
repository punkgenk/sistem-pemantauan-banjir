<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware: role
 * Penggunaan di route: ->middleware('role:masyarakat')
 *                 atau ->middleware('role:pemerintah')
 *
 * Daftarkan di bootstrap/app.php (Laravel 11):
 *   ->withMiddleware(function (Middleware $middleware) {
 *       $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
 *   })
 *
 * Atau di app/Http/Kernel.php (Laravel 10) di $routeMiddleware:
 *   'role' => \App\Http\Middleware\RoleMiddleware::class,
 */
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (! $request->user() || $request->user()->role !== $role) {
            return response()->json([
                'message' => 'Akses ditolak. Role tidak sesuai.',
            ], 403);
        }

        return $next($request);
    }
}
