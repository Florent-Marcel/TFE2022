<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class WebsiteLang
{
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
        }
        return $next($request);
    }
}
