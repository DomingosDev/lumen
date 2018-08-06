<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [ 'tag' => 'user.list'   , 'description' => 'Listar usuários do sistema' ]   ,
            [ 'tag' => 'user.add'    , 'description' => 'Adicionar usuário ao sistema' ] ,
            [ 'tag' => 'user.remove' , 'description' => 'Remover usuário do sistema' ]   ,
            [ 'tag' => 'user.edit'   , 'description' => 'Editar usuário do sistema' ]    ,
        ];

       $role_groups = [
            [ 'tag' => 'admin' , 'description' => 'Administrador do sistema' ],
            [ 'tag' => 'user'  , 'description' => 'Usuário do sistema'       ],
        ];

        $user_group_roles = [ 
            [ "user_group_id" => 1, "role_id" => 1 ],
            [ "user_group_id" => 1, "role_id" => 2 ],
            [ "user_group_id" => 1, "role_id" => 3 ],
            [ "user_group_id" => 1, "role_id" => 4 ],
            [ "user_group_id" => 2, "role_id" => 1 ],
        ];

        DB::table('roles')->insert( $roles );
        DB::table('user_groups')->insert( $role_groups );
        DB::table('user_group_roles')->insert( $user_group_roles );
    }
}