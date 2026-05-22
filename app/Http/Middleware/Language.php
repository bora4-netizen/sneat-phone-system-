<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cookie;
use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = Cookie::get('locale');
        $getLocale = $request->route()->lang;
        $defaultLocale = config('app.fallback_locale');
        if ($getLocale != null) {
            $defaultLocale = $getLocale;
        } else if($locale != null) {
            $defaultLocale = $locale;
        }
        if ($getLocale == null) {
            return redirect()->route('dashboard', withLang());
        }

        Cookie::queue(cookie('locale', $defaultLocale, config('app.cookie.lifetime')));
        app()->setLocale($defaultLocale);
        return $next($request);
    }
}
