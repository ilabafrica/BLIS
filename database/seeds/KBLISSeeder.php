<?php namespace Database\Seeds;

class KBLISSeeder extends DatabaseSeeder
{
    public function run()
    {

        /* Permissions table */
        $permissions = array(
            array("name" => "view_names", "display_name" => "Can view patient names"),
            array("name" => "manage_patients", "display_name" => "Can add patients"),

            array("name" => "receive_external_test", "display_name" => "Can receive test requests"),
            array("name" => "request_test", "display_name" => "Can request new test"),
            array("name" => "accept_test_specimen", "display_name" => "Can accept test specimen"),
            array("name" => "reject_test_specimen", "display_name" => "Can reject test specimen"),
            array("name" => "change_test_specimen", "display_name" => "Can change test specimen"),
            array("name" => "start_test", "display_name" => "Can start tests"),
            array("name" => "enter_test_results", "display_name" => "Can enter tests results"),
            array("name" => "edit_test_results", "display_name" => "Can edit test results"),
            array("name" => "verify_test_results", "display_name" => "Can verify test results"),
            array("name" => "send_results_to_external_system", "display_name" => "Can send test results to external systems"),
            array("name" => "refer_specimens", "display_name" => "Can refer specimens"),

            array("name" => "manage_users", "display_name" => "Can manage users"),
            array("name" => "manage_test_catalog", "display_name" => "Can manage test catalog"),
            array("name" => "manage_lab_configurations", "display_name" => "Can manage lab configurations"),
            array("name" => "view_reports", "display_name" => "Can view reports")
        );
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        $this->command->info('Permissions table seeded');

        /* Roles table */
        $roles = array(
            array("name" => "Superadmin"),
            array("name" => "Technologist"),
            array("name" => "Receptionist")
        );
        foreach ($roles as $role) {
            Role::create($role);
        }
        $this->command->info('Roles table seeded');

        $role1 = Role::find(1);
        $permissions = Permission::all();

        //Assign all permissions to role administrator
        foreach ($permissions as $permission) {
            $role1->attachPermission($permission);
        }
        //Assign role Administrator to administrators
        User::find(1)->attachRole($role1);
        User::find(8)->attachRole($role1);
        User::find(10)->attachRole($role1);


        $role2 = Role::find(2);//Technologist

        //Assign technologist's permissions to role technologist
        $role2->attachPermission(Permission::find(1));
        $role2->attachPermission(Permission::find(2));
        $role2->attachPermission(Permission::find(3));
        $role2->attachPermission(Permission::find(4));
        $role2->attachPermission(Permission::find(5));
        $role2->attachPermission(Permission::find(6));
        $role2->attachPermission(Permission::find(7));
        $role2->attachPermission(Permission::find(8));
        $role2->attachPermission(Permission::find(9));
        $role2->attachPermission(Permission::find(10));
        $role2->attachPermission(Permission::find(11));
        $role2->attachPermission(Permission::find(12));
        $role2->attachPermission(Permission::find(13));
        $role2->attachPermission(Permission::find(17));

        //Assign role Technologist to the other users
        User::find(2)->attachRole($role2);
        User::find(5)->attachRole($role2);
        User::find(12)->attachRole($role2);
        User::find(18)->attachRole($role2);
        User::find(23)->attachRole($role2);
        User::find(24)->attachRole($role2);
        User::find(26)->attachRole($role2);
        User::find(29)->attachRole($role2);
        User::find(43)->attachRole($role2);
        User::find(76)->attachRole($role2);
        User::find(136)->attachRole($role2);
        User::find(159)->attachRole($role2);
        User::find(161)->attachRole($role2);
        User::find(162)->attachRole($role2);
        User::find(163)->attachRole($role2);
        User::find(164)->attachRole($role2);

        /* Instruments table */
        $instrumentsData = array(
            "name" => "Celltac F Mek 8222",
            "description" => "Automatic analyzer with 22 parameters and WBC 5 part diff Hematology Analyzer",
            "driver_name" => "KBLIS\\Plugins\\CelltacFMachine",
            "ip" => "192.168.1.12",
            "hostname" => "HEMASERVER"
        );

        $instrument = Instrument::create($instrumentsData);
        $instrument->testTypes()->attach(array(176));

        $this->command->info('Instruments table seeded');
    }

}
