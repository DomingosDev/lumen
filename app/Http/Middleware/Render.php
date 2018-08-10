<?php

namespace App\Http\Middleware;
use App\Helpers\UI;
use Closure;

class Render
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

        $route_params = $request->route()[1];
        if( !isset($route_params['template']) ) return 'Template not defined for the requested route';
        $template = $route_params['template'];

        $data =  $next($request);
       return UI::getInstance()->config($data->original)->render('login');
        
    }
}
