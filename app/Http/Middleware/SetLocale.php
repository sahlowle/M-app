<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
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
        $defaultLang = 'en';

        $lang = $request->get('lang',$defaultLang);

        $availableLang = [
            'en',
            'ar',
            'fr',
            'ur',
            'tr',
            'sw',
        ];

        $lang = in_array($lang,$availableLang) ? $lang : $defaultLang;

        app()->setLocale($lang);
        
        return $next($request);
    }
}
