<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use View;

class CheckName
{
    public function handle($request, Closure $next)
    {
        $userName = Auth::user();
        if (isset($userName)) {
            view()->share([
                'username' => $userName->name,
            ]);
        }
        return $next($request);
    }
}
