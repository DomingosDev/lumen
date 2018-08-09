<?php

namespace App\Http\Middleware;
use App\Helpers\UI;
use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;
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

        $app = app();

        $data =  $next($request);

        $m = new Mustache_Engine([ 
                                    'loader' => new Mustache_Loader_FilesystemLoader( $app->path() . '/Views', ['extension' => '.html']),
                                    'partials_loader' => new Mustache_Loader_FilesystemLoader( $app->path() . '/Views/partials', ['extension' => '.html']),
                                    'strict_callables' => true
                                ]);

        
       return $m->render('login', UI::getInstance()->config($data->original)); // "Hello World!"
        
    }
}
