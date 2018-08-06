<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
class RoleMiddleware
{
    public function handle($request, Closure $next) // ... roles
    {
        
        $roles = array_slice( func_get_args(), 2 );
        
        $if_true = Closure::fromCallable( 'static::if_true' );
        $map_roles = static::map_roles( $request->auth );



        if( array_reduce( array_map( $map_roles, $roles ), $if_true, false) ) return $next($request);
        
        $message = '403 - Client does not have access rights to the content so server is rejecting to give proper response.';
        return response()->json(['error' => $message], 403);        
            
    }

    public static function if_true($carry, $element){
        return $carry || $element;
    }

    public static function map_roles( $user ){
        return function($role) use ($user){
            return $user->can($role);
        };
    }


}