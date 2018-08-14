<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class UserController extends BaseController
{
    public function listUsers(){
        $users = \App\User::all();
        return ["users"=>$users] ;
    }
}
