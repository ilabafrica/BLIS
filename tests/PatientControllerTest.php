<?php
/**
 * Tests the PatientController functions that store, edit and delete patient infomation 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class PatientControllerTest extends TestCase 
{
	
	    public function setUp()
	    {
	    	parent::setUp();
	    	Artisan::call('migrate');
      		Artisan::call('db:seed');
			$this->setVariables();
	    }
	
	/**
	 * Contains the testing sample data for the PatientController.
	 *
	 * @return void
	 */
		public function setVariables(){
		// Initial sample storage data
		$this->input = array(
			'patient_number' => '6666',//Must be unique!
			'name' => 'Bob Tzhebuilder',
			'dob' => '1930-07-05',
			'gender' => '0',//male
			'email' => 'builderone@concretejungle.com',
			'address' => '788347 W3-x2 Down.croncrete',
			'phone_number' => '+189012402938',
		);

		// Edition sample data
		$this->inputUpdate = array(
			'patient_number' => '5555',
			'name' => 'Bob Thebuilder',
			'dob' => '1900-07-05',
			'gender' => '0',//male
			'email' => 'buildandt@concretejungle.com',
			'address' => '788357 W3-x2 Down.croncrete',
			'phone_number' => '+18966602938',
		);
	}
	/**
	 * Tests the store function in the PatientController
	 * @param  void
	 * @return int $testPatientId ID of Patient stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nPATIENT CONTROLLER TEST\n\n";

		$this->be(User::first());

  		 // Store the Patient Types
		$this->runStore($this->input);

		$patientSaved = Patient::orderBy('id','desc')->take(1)->get()->toArray();
		
		$this->assertEquals($patientSaved[0]['patient_number'], $this->input['patient_number']);
		$this->assertEquals($patientSaved[0]['name'], $this->input['name']);
		$this->assertEquals($patientSaved[0]['dob'], $this->input['dob']);
		$this->assertEquals($patientSaved[0]['gender'], $this->input['gender']);
		$this->assertEquals($patientSaved[0]['email'], $this->input['email']);
		$this->assertEquals($patientSaved[0]['address'], $this->input['address']);
		$this->assertEquals($patientSaved[0]['phone_number'], $this->input['phone_number']);
  	}

  	/**
  	* Tests the update function in the PatientController
     	* @depends testStore
	* @param  void
	* @return void
     */
	public function testUpdate()
	{
		$this->be(User::first());
		
		$this->runStore($this->input);
		$patientSaved = Patient::orderBy('id','desc')->take(1)->get()->toArray();
		// Update the Patient Types
		$this->runUpdate($this->inputUpdate, $patientSaved[0]['id']);

		$patientUpdated = Patient::orderBy('id','desc')->take(1)->get()->toArray();

		$this->assertEquals($patientUpdated[0]['patient_number'], $this->inputUpdate['patient_number']);
		$this->assertEquals($patientUpdated[0]['name'], $this->inputUpdate['name']);
		$this->assertEquals($patientUpdated[0]['dob'], $this->inputUpdate['dob']);
		$this->assertEquals($patientUpdated[0]['gender'], $this->inputUpdate['gender']);
		$this->assertEquals($patientUpdated[0]['email'], $this->inputUpdate['email']);
		$this->assertEquals($patientUpdated[0]['address'], $this->inputUpdate['address']);
		$this->assertEquals($patientUpdated[0]['phone_number'], $this->inputUpdate['phone_number']);
	}

	
	
	/**
  	 * Tests the update function in the PatientController
     * @depends testStore
	 * @param void
	 * @return void
     */
	public function testDelete()
	{
		$this->be(User::first());
		
		$this->runStore($this->input);
		$patientSaved = Patient::orderBy('id','desc')->take(1)->get()->toArray();

		$patient = new PatientController;
    	$patient->delete($patientSaved[0]['id']);
		$patientsDeleted = Patient::withTrashed()->find($patientSaved[0]['id']);
		$this->assertNotNull($patientsDeleted->deleted_at);
	}
	
	
  	/**
  	 *Executes the store function in the PatientController
  	 * @param  array $input Patient details
	 * @return void
  	 */
	public function runStore($input)
	{
		Input::replace($input);
	    	$patient = new PatientController;
	    	$patient->store();
	}

  	/**
  	 * Executes the update function in the PatientController
  	 * @param  array $input Patient details, int $id ID of the Patient stored
	 * @return void
  	 */
	public function runUpdate($input, $id)
	{
		Input::replace($input);
    	$patient = new PatientController;
    	$patient->update($id);
	}

}