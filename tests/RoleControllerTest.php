<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\RoleController;
use Illuminate\Foundation\Testing\WithoutMiddleware;
class RoleControllerTest extends TestCase 
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
        Session::start();
        $this->setVariables();
    }

    public function testSaveUserRoleAssignment()
    {
        echo "\n\nROLE CONTROLLER TEST\n\n";

        // Set SOURCE URL - the index page for roles
        Session::put('SOURCE_URL', URL::route('role.assign'));

        // Invoke controller function
        $this->call('POST', 'role/assign', $this->userRolesMapping);

        $user1 = User::find(1);
        $user2 = User::find(2);
        $user3 = User::find(3);
        $role1 = Role::find(1);
        $role2 = Role::find(2);

        $this->assertTrue($user1->hasRole($role1->name));
        $this->assertTrue($user2->hasRole($role2->name));
        $this->assertTrue($user3->hasRole($role2->name));
        $this->assertFalse($user3->hasRole($role1->name));
        $this->assertFalse($user1->hasRole($role2->name));
        $this->assertRedirectedToRoute('role.assign');
    }

    public function testStore()
    {
        $this->call('POST', '/role', $this->systemRoleWorks);
        $role4 = Role::find(4);
        $this->assertEquals($this->systemRoleWorks['name'], $role4->name);

        $this->call('POST', '/role', $this->systemRoleFailsValidationNoName);
        $this->assertRedirectedToRoute('role.create');
        $this->assertSessionHasErrors('name');

        $this->call('POST', '/role', $this->systemRoleFailsValidationSameRole);
        $this->assertRedirectedToRoute('role.create');
        $this->assertSessionHasErrors('name');

        $this->call('POST', '/role', $this->systemRoleFailsValidationShortRole);
        $this->assertRedirectedToRoute('role.create');
        $this->assertSessionHasErrors('name');
    }

    public function testUpdate()
    {
        // Set SOURCE URL - the index page for roles
        Session::put('SOURCE_URL', URL::route('role.index'));

        $this->call('PUT', '/role/'.$id, $this->systemRoleUpdateWorks);
        $role1 = Role::find(1);
        $this->assertEquals($this->systemRoleUpdateWorks['name'], $role1->name);
        $this->assertEquals($this->systemRoleUpdateWorks['description'], $role1->description);
        $this->assertRedirectedToRoute('role.index');

        $this->call('PUT', '/role/'.$id, $this->systemRoleUpdateChecksForUniqNameExceptThisId);
        $role2 = Role::find(2);
        $this->assertEquals($this->systemRoleUpdateChecksForUniqNameExceptThisId['name'], $role2->name);
        $this->assertEquals($this->systemRoleUpdateChecksForUniqNameExceptThisId['description'], $role2->description);
        $this->assertRedirectedToRoute('role.index');

        $this->call('PUT', '/role/'.$id, $this->systemRoleUpdateFailsUpdatingWithExistingName);
        $role2 = Role::find(2);
        $this->assertNotEquals($this->systemRoleUpdateFailsUpdatingWithExistingName['name'], $role2->name);
        $this->assertRedirectedToRoute('role.edit', array(2));
        $this->assertSessionHasErrors('name');
    }

    public function testDelete()
    {
        // Set SOURCE URL - the index page for roles
        Session::put('SOURCE_URL', URL::route('role.index'));
        
        $this->call('GET', '/role/2/delete');
        $role2 = Role::find(2);
        $this->assertNull($role2);
        $this->assertRedirectedToRoute('role.index');
    }

    public function setVariables()
    {   
        /**
        * Mimics the array values received from the 
        * route role.assign for assigning roles to Users.
        */
        $this->userRolesMapping['userRoles'] = array(
            array(0=>"1"), array(0=>"1",1=>"1"), array(1=>"1"));

        //Save user roles
        $this->systemRoleWorks= array("name" => "Consigliere", "description" => "the henchman");
        $this->systemRoleFailsValidationNoName = array("description" => "Enforcers");
        $this->systemRoleFailsValidationSameRole= array("name" => "Consigliere", "description" => "lll");
        $this->systemRoleFailsValidationShortRole= array("name" => "Co");

        //Update user roles in seed KBLISSEEDER
        $this->systemRoleUpdateWorks= array("id"=>"1", "name" => "Ma na ge rs", "description" => "the managers");
        $this->systemRoleUpdateChecksForUniqNameExceptThisId= array("id"=>"2", "name" => "technologist", "description" => "the managers");
        $this->systemRoleUpdateFailsUpdatingWithExistingName= array("id"=>"2", "name" => "Ma na ge rs", "description" => "the managers");
        $this->roleController = new RoleController();
    }
}