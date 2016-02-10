<?php

class TestDataSeeder_empty extends DatabaseSeeder
{
    public function run()
    {
        /* Users table */
        $usersData = array(
            array(
                "username" => "administrator", "password" => Hash::make("password"), "email" => "admin@kblis.org",
                "name" => "kBLIS Administrator", "designation" => "Programmer"
            ),
            
        );

        foreach ($usersData as $user)
        {
            $users[] = User::create($user);
        }
        $this->command->info('users seeded');
        
    }

}
