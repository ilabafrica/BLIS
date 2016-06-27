<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\RoleController;

class RoleControllerTest extends TestCase 
{
    
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

    // todo: deal with is
    // Failed asserting that false is true.
    public function testSaveUserRoleAssignment()
    {
        echo "\n\nROLE CONTROLLER TEST\n\n";

        // Set SOURCE URL - the index page for roles
        Session::put('SOURCE_URL', URL::route('role.assign'));

        // Invoke controller function
		$this->withoutMiddleware();
        // todo: make easier to understand... whats going on here
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
        // todo: redirect is failing for some reason -ereng
        $this->assertRedirectedToRoute('role.assign');
    }

    public function testStore()
    {
        $this->withoutMiddleware();
        $this->call('POST', '/role', $this->systemRoleWorks);
        $role4 = Role::find(4);
        $this->assertEquals($this->systemRoleWorks['name'], $role4->name);

        $this->withoutMiddleware();
        $this->call('POST', '/role', $this->systemRoleFailsValidationNoName);
        // todo: redirect is failing for some reason -ereng
        $this->assertRedirectedToRoute('role.create');
        // todo: session don't seem to be working - ereng
        $this->assertSessionHasErrors('name');

        $this->withoutMiddleware();
        $this->call('POST', '/role', $this->systemRoleFailsValidationSameRole);
        // todo: redirect is failing for some reason -ereng
        $this->assertRedirectedToRoute('role.create');
        // todo: session don't seem to be working - ereng
        $this->assertSessionHasErrors('name');

        $this->withoutMiddleware();
        $this->call('POST', '/role', $this->systemRoleFailsValidationShortRole);
        // $this->assertRedirectedToRoute('role.create');
        $this->assertSessionHasErrors('name');
    }

    public function testUpdate()
    {
        // Set SOURCE URL - the index page for roles
        Session::put('SOURCE_URL', URL::route('role.index'));

        $this->withoutMiddleware();
        $this->call('PUT', '/role/1', $this->systemRoleUpdateWorks);
        $role1 = Role::find(1);
        $this->assertEquals($this->systemRoleUpdateWorks['name'], $role1->name);
        $this->assertEquals($this->systemRoleUpdateWorks['description'], $role1->description);
        // todo: redirect is failing for some reason -ereng
        $this->assertRedirectedToRoute('role.index');

        $this->withoutMiddleware();
        $this->call('PUT', '/role/2', $this->systemRoleUpdateChecksForUniqNameExceptThisId);
        $role2 = Role::find(2);
        $this->assertEquals($this->systemRoleUpdateChecksForUniqNameExceptThisId['name'], $role2->name);
        $this->assertEquals($this->systemRoleUpdateChecksForUniqNameExceptThisId['description'], $role2->description);
        // todo: redirect is failing for some reason -ereng
        $this->assertRedirectedToRoute('role.index');

        $this->withoutMiddleware();
        $this->call('PUT', '/role/2', $this->systemRoleUpdateFailsUpdatingWithExistingName);
        $role2 = Role::find(2);
        $this->assertNotEquals($this->systemRoleUpdateFailsUpdatingWithExistingName['name'], $role2->name);
        // todo: redirect is failing for some reason -ereng
        $this->assertRedirectedToRoute('role.edit', array(2));
        // todo: session don't seem to be working - ereng
        $this->assertSessionHasErrors('name');
    }

    public function testDelete()
    {
        // Set SOURCE URL - the index page for roles
        Session::put('SOURCE_URL', URL::route('role.index'));
        
        $this->call('GET', '/role/2/delete');
        $role2 = Role::find(2);
        $this->assertNull($role2);
        // todo: redirect is failing for some reason -ereng
        $this->assertRedirectedToRoute('role.index');
    }

    public function setVariables()
    {   
        /**
        * Mimics the array values received from the 
        * route role.assign for assigning roles to Users.
        */
        // todo: make easier to understand... whats going on here
        // todo: check for it's usage (entrust)
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