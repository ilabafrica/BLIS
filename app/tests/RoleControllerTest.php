<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
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
        $this->setVariables();
    }

    public function testSaveUserRoleAssignment()
    {
        echo "\n\nROLE CONTROLLER TEST\n\n";

        $this->action('POST', 'RoleController@saveUserRoleAssignment', $this->userRolesMapping);

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
        $this->action('POST', 'RoleController@store', $this->systemRoleWorks);
        $role3 = Role::find(3);
        $this->assertEquals($this->systemRoleWorks['name'], $role3->name);

        $this->action('POST', 'RoleController@store', $this->systemRoleFailsValidationNoName);
        $this->assertRedirectedToRoute('role.create');
        $this->assertSessionHasErrors('name');

        $this->action('POST', 'RoleController@store', $this->systemRoleFailsValidationSameRole);
        $this->assertRedirectedToRoute('role.create');
        $this->assertSessionHasErrors('name');

        $this->action('POST', 'RoleController@store', $this->systemRoleFailsValidationShortRole);
        $this->assertRedirectedToRoute('role.create');
        $this->assertSessionHasErrors('name');
    }

    public function testUpdate()
    {
        $role1 = Role::find(1);
        $this->assertEquals("Manager", $role1->name);
        $this->action('PUT', 'RoleController@update', $this->systemRoleUpdateId1);
        
        $role1 = Role::find(1);
        $role2 = Role::find(2);
        
        $this->assertEquals($this->systemRoleUpdateId1['name'], $role1->name);
        $this->assertEquals($this->systemRoleUpdateId1['description'], $role1->description);
        $this->assertRedirectedToRoute('role.index');

        $this->action('PUT', 'RoleController@update', $this->systemRoleUpdateId2Fail);
        $this->assertRedirectedToRoute('role.index');
        $this->assertEquals($this->systemRoleUpdateId2Fail['description'], $role2->description);
    }

    public function testDelete()
    {
        $this->action('GET', 'RoleController@delete', array("id"=>2));
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
        $this->systemRoleUpdateId1= array("id"=>"1", "name" => "Ma na ge rs", "description" => "the managers");
        $this->systemRoleUpdateId2Fail= array("id"=>"2", "name" => "Cashier", "description" => "the managers");

        $this->roleController = new RoleController();
    }
}