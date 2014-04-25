<?php

class UserSeeder
extends DatabaseSeeder
{
    public function run()
    {
        DB::table('user')->delete();
        
        $users = array(
        	array(
                "username" => "administrator",
                "password" => Hash::make("password"),
                "email"    => "admin@example.com",
                "name"     => "kBLIS Administrator",
                "designation" => "Programmer"
            )
        );

        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}