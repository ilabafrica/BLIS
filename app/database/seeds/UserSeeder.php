<?php

class UserSeeder
extends DatabaseSeeder
{
    public function run()
    {
        $users = array(
        	array(
                "username" => "thomas.mapesa",
                "password" => Hash::make("n:nih:i"),
                "email"    => "mapesa@gmail.com"
            )
        );

        foreach ($users as $user)
        {
            User::create($user);
        }
    }
}