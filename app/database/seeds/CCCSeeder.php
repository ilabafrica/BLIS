<?php

class CCCSeeder extends DatabaseSeeder
{
    public function run()
    {
        //Seed for role
        $ccc = Role::create(array('name' => "CCC"));
        //Seed for permission
        $cccperm = permission::create(array("name" => "can_access_ccc_reports", "display_name" => "Can access CCC reports"));
        //Assign all ccc permission to role ccc
        $ccc->attachPermission($cccperm);
        $this->command->info("CCC role/permission seeded");
    }
}