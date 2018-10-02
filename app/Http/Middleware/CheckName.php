<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use View;

class CheckName
{
    public function handle($request, Closure $next)
    {
        $userName = Auth::user();
        if (isset($userName)) {
            view()->share([
                'username' => $userName->name,
                'email' => $userName->email,
            ]);
        }
        return $next($request);
    }
}
