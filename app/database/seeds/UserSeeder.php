<?php

class UserSeeder
extends DatabaseSeeder
{
    public function run()
    {
        DB::table('user')->delete();
        
        $users = array(
        	array(
                "username" => "thomas",
                "password" => Hash::make("password"),
                "email"    => "mapesa@gmail.com",
                "name"     => "Thomas Mapesa",
                "designation" => "Programmer"
            )
        );

        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}