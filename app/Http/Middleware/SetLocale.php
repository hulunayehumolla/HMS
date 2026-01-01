<?php

namespace App\Http\Middleware;

use Closure;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Default to 'en' if no locale is set
        App::SetLocale($request->Session()->get('locale', 'en'));

        return $next($request);
    }
}

