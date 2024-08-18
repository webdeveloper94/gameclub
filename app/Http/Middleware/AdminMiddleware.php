<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->type === 'admin') {
            return $next($request);
        }

        abort(403, 'Bu sahifaga kirishga ruxsat yo\'q.');
    }

    protected $routeMiddleware = [
        // Boshqa middleware lar
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];
}
