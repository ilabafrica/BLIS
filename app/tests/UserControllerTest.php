<?php
/**
 * Tests the UserController functions that store, edit and delete users 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class UserControllerTest extends TestCase 
{
	/**
	 * Contains the testing sample data for the UserController.
	 *
	 * @return void
	 */
    public function __construct()
    {
    	// Initial sample storage data
		$this->input = array(
			'username' => 'dot',
			'email' => 'johxdoe@example.com',
			'name' => 'John Dot',
			'gender' => '1',
			'designation' => 'LabTechnikan',
		);

		// Edition sample data
		$this->inputUpdate = array(
			'username' => 'doe',
			'email' => 'johndoe@example.com',
			'name' => 'John Doe',
			'gender' => '0',
			'designation' => 'LabTechnician',
		);

		$this->testUserId = NULL;
    }
	
	/**
	 * Tests the store function in the UserController
	 * @param  testing Sample from the constructor
	 * @return int $testUserId ID of User stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nUSER CONTROLLER TEST\n\n";
  		 // Store the User
		$this->runStore($this->input);

		$usersSaved = User::orderBy('id','desc')->take(1)->get();
		foreach ($usersSaved as $userSaved) {
			
			$this->testUserId = $userSaved->id;
			$this->assertEquals($userSaved->username , $this->input['username']);
			$this->assertEquals($userSaved->email , $this->input['email']);
			$this->assertEquals($userSaved->name , $this->input['name']);
			$this->assertEquals($userSaved->gender , $this->input['gender']);
			$this->assertEquals($userSaved->designation , $this->input['designation']);
					
			$testUserId = $this->testUserId;
		}
		echo "User created\n";
		return $testUserId;
  	}

  	/**
  	 * Tests the update function in the UserController
     * @depends testStore
	 * @param  int $testUserId User ID from testStore(), testing Sample from the constructor
	 * @return void
     */
	public function testUpdate($testUserId)
	{
		// Update the User Types
		$this->runUpdate($this->inputUpdate, $testUserId);

		$usersSaved = User::orderBy('id','desc')->take(1)->get();
		foreach ($usersSaved as $userSaved) {
			$this->assertEquals($userSaved->username , $this->inputUpdate['username']);
			$this->assertEquals($userSaved->email , $this->inputUpdate['email']);
			$this->assertEquals($userSaved->name , $this->inputUpdate['name']);
			$this->assertEquals($userSaved->gender , $this->inputUpdate['gender']);
			$this->assertEquals($userSaved->designation , $this->inputUpdate['designation']);
		}
		echo "User updated\n";
	}

	
	
	/**
  	 * Tests the update function in the UserController
     * @depends testStore
	 * @param  int $testUserId User ID from testStore()
	 * @return void
     */
	public function testDelete($testUserId)
	{
		$this->runDelete($testUserId);
		$usersSaved = User::withTrashed()->orderBy('id','desc')->take(1)->get();
		foreach ($usersSaved as $userSaved) {
			$this->assertNotNull($userSaved->deleted_at);
		}
		echo "\nUser softDeleted\n";
	    $this->removeTestData($testUserId);
		echo "sample User removed from the Database\n";
	}
	
	
  	/**
  	 *Executes the store function in the UserController
  	 * @param  array $input User details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
    	$user = new UserController;
    	$user->store();
	}

  	/**
  	 * Executes the update function in the UserController
  	 * @param  array $input User details, int $id ID of the User stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$user = new UserController;
    	$user->update($id);
	}

	/**
	 * Executes the delete function in the UserController
	 * @param  int $id ID of User stored
	 * @return void
	 */
	public function runDelete($id)
	{
		$user = new UserController;
    	$user->delete($id);
	}

	 /**
	  * Force delete all sample Users from the database
	  * @param  int $id User ID
	  * @return void
	  */
	public function removeTestData($id)
	{
		DB::table('users')->delete($id);
	}
}