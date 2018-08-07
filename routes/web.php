<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Http\Request;




$router->get('/', [
	'middleware' => 'example:tt',
	function () use ($router) {
        return $router->app->version();
	}]);

$router->post(
    'auth/login', 
    [
       'uses' => 'AuthController@authenticate'
    ]
);
$router->get(
    'auth/login', 
    [
       'uses' => 'AuthController@getForm'
    ]
);

$router->group(
    ['middleware' => [  
        'jwt.auth',  
        'role:user.list',
    ]], 
    function() use ($router) {
        $router->get('users', function() {
            $users = \App\User::with('roles')->get();
            return response()->json($users);
        });
    }
);



$router->get('/user-roles', [
    'middleware' => 'jwt.auth',
    function (Request $request) use ($router) {

    return $request->auth->getRoleTags();
}]);


$router->post('/validacao', [
    function (Request $request) use ($router) {

        $rules = [
            'name' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails() ) {
            $result = $validator->fails();
            var_dump($result);
            return $validator->errors();
        }

        


    return 'OK';
}]);