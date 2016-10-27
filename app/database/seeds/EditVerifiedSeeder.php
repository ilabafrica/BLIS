<?php

class EditVerifiedSeeder extends DatabaseSeeder
{
    public function run()
    {

        /* Permissions table */
        $permissions = array(
            array("name" => "edit_verified_results", "display_name" => "Can edit verified results"),
        );
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        $this->command->info('Edit verified results permission seeded');

        /* Attach permission to superadmin role */
        $role1 = Role::find(1);
        $permission = Permission::find(21);
        $role1->attachPermission($permission);
    }
}
