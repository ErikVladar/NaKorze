<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Session;
use Closure;

class SetLocale{

    public function handle($request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale'));
        App::setLocale($locale);

        return $next($request);
    }
}