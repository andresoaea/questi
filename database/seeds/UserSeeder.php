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
                'password'   => Hash::make('parola'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ),           
            array(
                'firstname'  => 'Stefan',
                'lastname'   => 'Calinescu',
                'username'   => 'moder',  
                'role'       => 'moderator',   
                'email'      => 'moder@site.com',           
                'password'   => Hash::make('parola'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ),           
            array(
                'firstname'  => 'George',
                'lastname'   => 'Popa',
                'username'   => 'georgepopa',  
                'role'       => 'user',   
                'email'      => 'george_popa@exmple.cc',           
                'password'   => Hash::make('parola'),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            )
        );

        DB::table('users')->insert($users);

        // Add some fake users
        $faker = \Faker\Factory::create();

        for($i=0; $i<=50; $i++):

            $email = $faker->unique()->safeEmail;
            $username = explode('@', $email, 2)[0];

            DB::table('users')
                ->insert([
                    'firstname'  => $faker->firstname,
                    'lastname'   => $faker->lastname,
                    'username'   => $username,  
                    'role'       => 'user',   
                    'email'      => $email,      
                    'password'   => Hash::make('parola'),
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);

        endfor;

       
    }
}