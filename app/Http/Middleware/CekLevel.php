<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLevel
{
    public function handle(Request $request, Closure $next, ...$level)
    {
        if (auth()->user() && in_array((int) auth()->user()->level, array_map('intval', $level))) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Hanya administrator utama yang diizinkan.');
    }
}
