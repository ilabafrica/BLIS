<?php
/**
 * Tests the UserController functions that store, edit and delete users 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

use App\Models\User;
use App\Http\Controllers\UserController;


class UserControllerTest extends TestCase 
{
    
    /**
    * Initial setup function for tests
    *
    * @return void
    */
    public function setUp(){
        parent::setUp();
        Artisan::call('migrate');
        $this->setVariables();
        $this->withoutMiddleware();
    }

    /**
     * Contains the testing sample data for the UserController.
     *
     * @return void
     */
    public function setVariables()
    {
    	// Initial sample storage data
		$this->userData = array(
			'username' => 'dotmatrix',
			'email' => 'johxdoe@example.com',
			'name' => 'John Dot',
            'designation' => 'LabTechnikan',
			'gender' => User::FEMALE,
            'password' => "goodpassword",
            'password_confirmation' => "goodpassword",
        );

        // Edition sample data
        $this->userDataUpdate = array(
          'email' => 'johndoe@example.com',
          'name' => 'John Doe',
          'gender' => User::MALE,
          'designation' => 'LabTechnician',
          'current_password' => 'goodpassword',
          'new_password' => 'newpassword',
          'new_password_confirmation' => 'newpassword',
        );

        // sample login data
        $this->userDataLoginBad = array(
            'username' => 'dotmatrix',
            'password' => 'wrongpassword',
        );

        // sample login data
        $this->userDataLoginGood = array(
            'username' => 'dotmatrix',
            'password' => 'goodpassword',
        );

        // sample login data
        $this->userDataLoginFailsVerification = array(
            'username' => 'dot',
            'password' => 'goo',
        );

    }
	
	/**
	 * Tests the store function in the UserController
	 * @return int $testUserId ID of User stored; used in testUpdate() to identify test for update
	 */    
	public function testRegister()
    {
        echo "\n\nUSER CONTROLLER TEST\n\n";
        // Store the User
        $this->call('POST', '/user', $this->userData);
        $userSaved = User::find(1);
        $this->assertEquals($userSaved->username , $this->userData['username']);
        $this->assertEquals($userSaved->email , $this->userData['email']);
        $this->assertEquals($userSaved->name , $this->userData['name']);
        $this->assertEquals($userSaved->gender , $this->userData['gender']);
        $this->assertEquals($userSaved->designation , $this->userData['designation']);
    }

  /**
   * Tests the update function in the UserController
   * @param  void
   * @return void
   */
    public function testUpdate()
    {
        // Update the User Types
        $this->call('POST', '/user', $this->userData);
        $this->call('PUT', '/user/1', $this->userDataUpdate);
        $userUpdated = User::find(1);

        $this->assertEquals($this->userDataUpdate['email'], $userUpdated->email);
        $this->assertEquals($this->userDataUpdate['name'], $userUpdated->name);
        $this->assertEquals($this->userDataUpdate['gender'], $userUpdated->gender);
        $this->assertEquals($this->userDataUpdate['designation'], $userUpdated->designation);
    }

    /**
     * Tests the update function in the UserController
     * @param  void
     * @return void
     */
    public function testDelete()
    {
        $this->call('POST', '/user', $this->userData);
        $this->call('DELETE', '/user/1/delete', $this->userData);
        $usersSaved = User::withTrashed()->find(1);
        $this->assertNotNull($usersSaved->deleted_at);
    }

    public function testHandlesFailedLogin()
    {
        $this->call('POST', '/user/login', $this->userData);
        $this->assertRedirectedTo('/');
    }

    public function testHandlesValidLogin()
    {
        $this->call('POST', '/user', $this->userData);
        $this->call('POST', '/user/login', $this->userData);
        $this->assertRedirectedTo('home');
    }

    public function testHandlesLoginValidation()
    {
        $this->call('POST', '/user/login', $this->userData);
        $this->assertRedirectedTo('/');
    }
}