<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    public function roles(){
    	return $this->belongsToMany('App\Role', 'user_group_roles');
    }
}
