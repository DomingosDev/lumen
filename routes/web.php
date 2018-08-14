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


$url_register = function($router){
    $router->get('/', [
        'template' => 'main.html',
        function () use ($router) {
            return [
            "message" => "",
            "fields" => [
                    [
                        "type"  => "email",
                        "name"  => "email",
                        "placeholder" => "Your Email",
                        "value" => "domingos.dev@gmail.com",
                        "error" => [
                            'Novo teste 123',
                            'novo erro 123213'
                        ],
                    ],
                    [
                        "type"  => "password",
                        "name"  => "password",
                        "value" => "12345",
                        "error" => false,
                    ],
                    [
                        "type"    => "checkbox",
                        "name"    => "remember",
                        "error"   => false,
                        "checked" => false,
                        "label"   => "Remember me"
                    ]
                ]
            ];
        }]);

    $router->post( '/login',  [ 'uses' => 'AuthController@authenticate', 'template'=>'login.html' ] );
    $router->get( '/login',   [ 'uses' => 'AuthController@getForm', 'template'=>'login.html' ] );

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

    $router->get('/teste', [ 'as' => 'teste123', 'template'=>'opalele', function(Request $request){
        var_dump( $request->route()[1]['as'] );
        return 'OK';
    }]);


    $router->post('/validacao', [
        function (Request $request) use ($router) {

            $rules = [ 'name' => 'required' ];

            $validator = Validator::make($request->all(), $rules);

            if ( $validator->fails() ) {
                $result = $validator->fails();
                var_dump($result);
                return $validator->errors();
            }
        return 'OK';
    }]);

};

$router->group(['prefix' => 'api'], $url_register );
$router->group(['prefix' => '', 'middleware' => 'render'], $url_register );