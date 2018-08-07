<?php

namespace App\Http\Middleware;

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
        $template = $request->route()[1]['template'];

        var_dump( $template );
        return $next($request);
    }
}
