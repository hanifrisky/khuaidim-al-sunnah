<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!config('app.show_language_switcher', true)) {
            App::setLocale('ar');
            return $next($request);
        }

        $locale = Session::get('locale', config('app.locale', 'ar'));
        if (in_array($locale, ['ar', 'id'])) {
            App::setLocale($locale);
        } else {
            App::setLocale('ar');
        }

        return $next($request);
    }
}
