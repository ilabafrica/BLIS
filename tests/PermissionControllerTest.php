<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\PermissionController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class PermissionControllerTest extends TestCase 
{

    use WithoutMiddleware;
    /**
     * Default preparations for tests
     *
     * @return void
     */
    public function setup()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->setVariables();
    }

    public function testStore()
    {
        echo "\n\nPERMISSION CONTROLLER TEST\n\n";

        $this->action('POST', 'PermissionController@store', $this->permissionRolesMapping);

        $permission1 = Permission::find(1);
        $permission2 = Permission::find(2);
        $permission3 = Permission::find(3);
        $role1 = Role::find(1);
        $role2 = Role::find(2);

        $this->assertTrue($permission1->hasRole($role1->name));
        $this->assertTrue($permission2->hasRole($role2->name));
        $this->assertTrue($permission3->hasRole($role2->name));
        $this->assertFalse($permission3->hasRole($role1->name));
        $this->assertFalse($permission1->hasRole($role2->name));
        $this->assertRedirectedToRoute('permission.index');
    }

    public function setVariables()
    {   
        /**
        * Mimics the array values received from the 
        * route permission for assigning permissions to roles
        */
        $this->permissionRolesMapping['permissionRoles'] = array(
            array(0=>"1"), array(0=>"1",1=>"1"), array(1=>"1"));

        $this->permissionController = new PermissionController();
    }
}