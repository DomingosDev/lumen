<?php
namespace App\Http\Controllers;

use Closure;
use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController 
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->id,
            'iat' => time(), 
            'exp' => time() + 60*60
        ];
        
        return JWT::encode($payload, env('JWT_SECRET'));
    } 

    public function authenticate(Request $request, User $user) {
        $rules = [
            'email'     => 'required|email',
            'password'  => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );
        $validator->after( $this->getCustomValidator() );

        if ( $validator->fails() ) return $this->getLoginForm( $request->all(), $validator->errors() );;

        return response()->json([ 'token' => $this->jwt($user) ], 200);
    }

    public function getCustomValidator(){
        return function($validator){
            $user = User::where('email', $this->request->input('email'))->first();
            if (!$user) return $validator->errors()->add('email', 'Email does not exist.');
            if ( Hash::check($this->request->input('password'), $user->password) ) return;
            $validator->errors()->add('password', 'Password is wrong.');
        };
    }

    public function getForm(){
        return $this->getLoginForm();
    }

    public function getLoginForm($values = [], $errors = null){
        $form = [
            "message" => "",
            "fields" => [
                [
                    "type" => "email",
                    "name" => "email",
                    "value" => $values['email'] ?? "",
                    "error" => $errors ? $errors->get('email') : false,
                ],
                [
                    "type" => "password",
                    "name" => "password",
                    "value" => $values['password'] ?? "",
                    "error" => $errors ? $errors->get('password') : false,
                ]
            ]
        ];

        return $form;
    }
    

}