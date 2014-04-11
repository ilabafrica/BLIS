<?php

class UserSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $users = array(
        	array(
                "username" => "thomas",
                "password" => Hash::make("password"),
                "email"    => "mapesa@gmail.com"
            )
        );

        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}