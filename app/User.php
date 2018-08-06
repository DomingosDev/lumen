<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $role_tags = null;

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function getRoleTags($refresh = false)
    {
        if( !empty($this->role_tags) && !$refresh) return $this->role_tags;

        $roles = $this->roles->toArray();
        $getRoleTag = function ( $element ) { return $element['tag']; };
        $this->role_tags = array_map(  $getRoleTag, $roles );
        return $this->role_tags;

    }

    public function can( $ability, $arguments = [] )
    {
        return in_array( $ability, $this->getRoleTags() );
    }

    public function cant( $ability, $arguments = [] )
    {
        return !$this->can( $ability );
    }
}