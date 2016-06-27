<?php  namespace Database\Seeds;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Instrument;

class KBLISSeeder extends Seeder
{
    public function run()
    {

        $role1 = Role::find(1);
        $role2 = Role::find(2);//Technologist
        $permissions = Permission::all();

        //Assign all permissions to role administrator
        foreach ($permissions as $permission) {
            $role1->attachPermission($permission);
        }
        //Assign role Administrator to administrators
        User::find(1)->attachRole($role1);
        User::find(2)->attachRole($role2);
        // User::find(8)->attachRole($role1);
        // User::find(10)->attachRole($role1);



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
        // User::find(5)->attachRole($role2);
        // User::find(12)->attachRole($role2);
        // User::find(18)->attachRole($role2);
        // User::find(23)->attachRole($role2);
        // User::find(24)->attachRole($role2);
        // User::find(26)->attachRole($role2);
        // User::find(29)->attachRole($role2);
        // User::find(43)->attachRole($role2);
        // User::find(76)->attachRole($role2);
        // User::find(136)->attachRole($role2);
        // User::find(159)->attachRole($role2);
        // User::find(161)->attachRole($role2);
        // User::find(162)->attachRole($role2);
        // User::find(163)->attachRole($role2);
        // User::find(164)->attachRole($role2);

    }

}
