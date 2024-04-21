<?php

namespace App\Http\Middleware;

use App\Models\SessionModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            $sessionLanguage = SessionModel::getLanguageById(Session::getId());
            if (empty($sessionLanguage)) {
                $sessionLanguage = SessionModel::setLanguage(config('app.locale'), Session::getId());
            }
            app()->setLocale($sessionLanguage);

            return $next($request);
        }
        app()->setLocale($request->user()->language);

        return $next($request);
    }
}
