<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function listUsers(){
        $users = \App\User::all();
        return ["users"=>$users] ;
    }

    public function authenticate(Request $request, User $user) {

        $rules = [
        	'name'		=> 'required',
            'email'     => 'required|email',
            'password'  => 'required',
            'passoword-confirm' => 'required|same:password'
        ];

        $validator = Validator::make( $request->all(), $rules );

        if ( $validator->fails() ) return $this->getForm( $request->all(), $validator->errors() );


        return response()->json([ 'redirect' => $user->getRedirectRoute() ], 200);
    }



 	public function getCustomValidator($user){
        return function($validator) use ($user){
            if (!$user) return $validator->errors()->add('email', 'Email does not exist.');
            if ( Hash::check($this->request->input('password'), $user->password) ) return;
            $validator->errors()->add('password', 'Password is wrong.');
        };
    }



    public function getForm($values = [], $errors = null){
        $form = [
            "message" => "",
            "fields" => [
                [
                    "type"  => "email",
                    "name"  => "email",
                    "value" => $values['email'] ?? "",
                    "error" => $errors ? $errors->get('email') : false,
                ],
                [
                    "type"  => "password",
                    "name"  => "password",
                    "value" => $values['password'] ?? "",
                    "error" => $errors ? $errors->get('password') : false,
                ],
                [
                    "type"    => "checkbox",
                    "name"    => "remember_me",
                    "checked" => false,
                    "label"   => "Remember me",
                    "value" => $values['remember_me'] ?? "",
                    "error" => $errors ? $errors->get('remember_me') : false,
                ]
            ]
        ];

        return $form;
    }

}
