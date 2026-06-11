<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cookie;
use Closure;

class Language
{
    public function handle($request, Closure $next)
    {
        $allowedLocales = ['en', 'kh']; // add all your supported locales here

        // Read lang from query string (?lang=en), fall back to cookie, then app default
        $getLocale   = $request->query('lang');
        $cookieLocale = Cookie::get('locale');
        $defaultLocale = config('app.fallback_locale');

        if ($getLocale && in_array($getLocale, $allowedLocales)) {
            $defaultLocale = $getLocale;
        } elseif ($cookieLocale && in_array($cookieLocale, $allowedLocales)) {
            $defaultLocale = $cookieLocale;
        }

        Cookie::queue(cookie('locale', $defaultLocale, config('app.cookie.lifetime')));
        app()->setLocale($defaultLocale);

        return $next($request);
    }
}