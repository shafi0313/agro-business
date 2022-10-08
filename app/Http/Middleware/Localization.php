<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $availableLocale = ['en','bn'];
        $locale = session('APP_LOCALE');
        $locale = in_array($locale, $availableLocale) ? $locale: config('app.locale');
        app()->setlocale($locale);
        return $next($request);
    }
}
