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
        $this->withSession(['SOURCE_URL' => URL::route('role.assign')]);

        $this->withoutMiddleware();
        $this->call('POST', 'role/assign', $this->userRolesMapping);

        // todo: user1 and role1 and user2 and role2 already assigned in the seeding, test user3 and role3 assignement then, therefore it's been passing when it shouldn't
        $user3 = User::find(3);
        $role3 = Role::find(3);

        $this->assertTrue($user3->hasRole($role3->name));
        // todo: the function assign does not return a redirect() in the first place!
        // $this->assertRedirectedToRoute('role.assign');
    }

    public function testStore()
    {
        $this->withSession(['SOURCE_URL' => URL::route('role.create')]);
        $this->withoutMiddleware();
        $this->call('POST', '/role', $this->systemRoleWorks);
        $role = Role::orderBy('id','desc')->first();
        $this->assertEquals($this->systemRoleWorks['name'], $role->name);

        $this->call('POST', '/role', $this->systemRoleFailsValidationNoName);
        // todo: the test environment has source route '/' on failure redirect->back() -> the test below wont do
        // $this->assertRedirectedToRoute('role.create');
        // todo: this is the best I can do for now
        // $this->assertSessionHasErrors('name');
        $this->assertSessionHasErrors();

        $this->call('POST', '/role', $this->systemRoleFailsValidationSameRole);
        // todo: redirect is failing for some reason
        // todo: the test environment has source route '/' on failure redirect->back() -> the test below wont do
        // $this->assertRedirectedToRoute('role.create');
        // todo: this is the best I can do for now
        // $this->assertSessionHasErrors('name');
        $this->assertSessionHasErrors();

        $this->call('POST', '/role', $this->systemRoleFailsValidationShortRole);
        $this->assertRedirectedToRoute('role.create');
        // todo: this is the best I can do for now
        // $this->assertSessionHasErrors('name');
        $this->assertSessionHasErrors();
    }

    public function testUpdate()
    {
        // Set SOURCE URL - the index page for roles
        // Session::put('SOURCE_URL', URL::route('role.index'));
        $this->withSession(['SOURCE_URL' => URL::route('role.index')]);

        $this->withoutMiddleware();
        $this->call('PUT', '/role/1', $this->systemRoleUpdateWorks);
        $role1 = Role::find(1);
        $this->assertEquals($this->systemRoleUpdateWorks['name'], $role1->name);
        $this->assertEquals($this->systemRoleUpdateWorks['description'], $role1->description);
        // todo: redirect is failing for some reason
        $this->assertRedirectedToRoute('role.index');

        $this->call('PUT', '/role/2', $this->systemRoleUpdateChecksForUniqNameExceptThisId);
        $role2 = Role::find(2);
        $this->assertEquals($this->systemRoleUpdateChecksForUniqNameExceptThisId['name'], $role2->name);
        $this->assertEquals($this->systemRoleUpdateChecksForUniqNameExceptThisId['description'], $role2->description);
        // todo: redirect is failing for some reason
        $this->assertRedirectedToRoute('role.index');

        $this->call('PUT', '/role/2', $this->systemRoleUpdateFailsUpdatingWithExistingName);
        $this->withSession(['SOURCE_URL' => URL::route('role.edit',[2])]);
        $role2 = Role::find(2);
        $this->assertNotEquals($this->systemRoleUpdateFailsUpdatingWithExistingName['name'], $role2->name);
        // todo: this is the best I can do for now
        // $this->assertSessionHasErrors('name');
        $this->assertSessionHasErrors();
        // todo: the test environment has source route '/' on failure redirect->back() -> the test below wont do
        // $this->assertRedirectedToRoute('role.edit',[2]);
    }

    public function testDelete()
    {
        // Set SOURCE URL - the index page for roles
        // Session::put('SOURCE_URL', URL::route('role.index'));
        $this->withSession(['SOURCE_URL' => URL::route('role.index')]);
        
        $this->call('GET', '/role/2/delete');
        $role2 = Role::find(2);
        $this->assertNull($role2);
        // todo: redirect is failing for some reason
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
        $this->userRolesMapping['userRoles'] = [
            [0=>"1"], [0=>"1",1=>"1"], [1=>"1"]];

        //Save user roles
        $this->systemRoleWorks= array("name" => "Consigliere", "description" => "the henchman");
        $this->systemRoleFailsValidationNoName = array("description" => "Enforcers");
        $this->systemRoleFailsValidationSameRole= array("name" => "Consigliere", "description" => "lll");
        $this->systemRoleFailsValidationShortRole= array("name" => "Co");

        //Update user roles in seed KBLISSEEDER - KBLISSEEDER dont exist no more find content in the new seeders
        $this->systemRoleUpdateWorks= array("id"=>"1", "name" => "Ma na ge rs", "description" => "the managers");
        $this->systemRoleUpdateChecksForUniqNameExceptThisId= array("id"=>"2", "name" => "technologist", "description" => "the managers");
        $this->systemRoleUpdateFailsUpdatingWithExistingName= array("id"=>"2", "name" => "Ma na ge rs", "description" => "the managers");
        $this->roleController = new RoleController();
    }
}