<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $users = array(
            array(
                'firstname'  => 'Constantin',
                'lastname'   => 'Developer',
                'username'   => 'admin',  
                'role'       => 'administrator',   
                'email'      => 'admin@site.com',           
                'password'   => Hash::make('admin'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ),           
            array(
                'firstname'  => 'Moderator',
                'lastname'   => 'Mod',
                'username'   => 'moder',  
                'role'       => 'moderator',   
                'email'      => 'moder@site.com',           
                'password'   => Hash::make('moder'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ),           
            array(
                'firstname'  => 'George',
                'lastname'   => 'Stanescu',
                'username'   => 'georgestanescu',  
                'role'       => 'user',   
                'email'      => 'george_stanescu@yahoo.com',           
                'password'   => Hash::make('george'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );

        DB::table('users')->insert($users);
    }
}