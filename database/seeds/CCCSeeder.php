<?php namespace Database\Seeds;

class CCCSeeder extends DatabaseSeeder
{
    public function run()
    {
        //Seed for role
        $ccc = Role::create(array('name' => "CCC Worker", 'description' => "CCC Section Workers"));
        //Seed for permission
        $cccperm = Permission::create(array("name" => "can_access_ccc_reports", "display_name" => "Can access CCC reports"));
        //Assign all ccc permission to role ccc
        DB::table('permission_role')->insert(array('permission_id' => $cccperm->id, 'role_id' => $ccc->id));
        $this->command->info("CCC role/permission seeded");
    }
}