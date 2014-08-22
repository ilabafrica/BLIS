<?php
/**
 * Tests the PatientController functions that store, edit and delete patient infomation 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
class PatientControllerTest extends TestCase 
{
	/**
	 * Contains the testing sample data for the PatientController.
	 *
	 * @return void
	 */
	    public function setUp()
	    {
	    	parent::setUp();
	    	Artisan::call('migrate');
		$this->setVariables();
	    }
	
	public function setVariables(){
		// Initial sample storage data
		$this->input = array(
			'patient_number' => '5681',
			'name' => 'Bob Thebuilder',
			'dob' => '1900-07-05',
			'gender' => '0',//male
			'email' => 'builderone@concretejungle.com',
			'address' => '788347 W3-x2 Down.croncrete',
			'phone_number' => '+189012402938',
		);

		// Edition sample data
		$this->inputUpdate = array(
			'patient_number' => '5681',
			'name' => 'Bob Thebuilder',
			'dob' => '1900-07-05',
			'gender' => '0',//male
			'email' => 'builderone@concretejungle.com',
			'address' => '788347 W3-x2 Down.croncrete',
			'phone_number' => '+189012402938',
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
  		 // Store the Patient Types
		$this->runStore($this->input);

		$patientSaved = Patient::find(1);
		
		$this->assertEquals($patientSaved->patient_number, $this->input['patient_number']);
		$this->assertEquals($patientSaved->name, $this->input['name']);
		$this->assertEquals($patientSaved->dob, $this->input['dob']);
		$this->assertEquals($patientSaved->gender, $this->input['gender']);
		$this->assertEquals($patientSaved->email, $this->input['email']);
		$this->assertEquals($patientSaved->address, $this->input['address']);
		$this->assertEquals($patientSaved->phone_number, $this->input['phone_number']);
  	}

  	/**
  	* Tests the update function in the PatientController
     	* @depends testStore
	* @param  void
	* @return void
     */
	public function testUpdate()
	{
		$this->runStore($this->input);
		// Update the Patient Types
		$this->runUpdate($this->inputUpdate, 1);

		$patientsUpdated = Patient::find(1);

		$this->assertEquals($patientsUpdated->patient_number, $this->inputUpdate['patient_number']);
		$this->assertEquals($patientsUpdated->name, $this->inputUpdate['name']);
		$this->assertEquals($patientsUpdated->dob, $this->inputUpdate['dob']);
		$this->assertEquals($patientsUpdated->gender, $this->inputUpdate['gender']);
		$this->assertEquals($patientsUpdated->email, $this->inputUpdate['email']);
		$this->assertEquals($patientsUpdated->address, $this->inputUpdate['address']);
		$this->assertEquals($patientsUpdated->phone_number, $this->inputUpdate['phone_number']);
	}

	
	
	/**
  	 * Tests the update function in the PatientController
     * @depends testStore
	 * @param void
	 * @return void
     */
	public function testDelete()
	{
		$this->runStore($this->input);

		$patient = new PatientController;
    		$patient->delete(1);
		$patientsDeleted = Patient::withTrashed()->find(1);
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