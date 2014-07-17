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
    public function __construct()
    {
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

		$this->testPatientId = NULL;
    }
	
	/**
	 * Tests the store function in the PatientController
	 * @param  testing Sample from the constructor
	 * @return int $testPatientId ID of Patient stored; used in testUpdate() to identify test for update
	 */    
 	public function testStore() 
  	{
		echo "\n\nPATIENT CONTROLLER TEST\n\n";
  		 // Store the Patient Types
		$this->runStore($this->input);

		$patientsSaved = Patient::orderBy('id','desc')->take(1)->get();
		foreach ($patientsSaved as $patientSaved) {
			$this->testPatientId = $patientSaved->id;
			$this->assertEquals($patientSaved->patient_number, $this->input['patient_number']);
			$this->assertEquals($patientSaved->name, $this->input['name']);
			$this->assertEquals($patientSaved->dob, $this->input['dob']);
			$this->assertEquals($patientSaved->gender, $this->input['gender']);
			$this->assertEquals($patientSaved->email, $this->input['email']);
			$this->assertEquals($patientSaved->address, $this->input['address']);
			$this->assertEquals($patientSaved->phone_number, $this->input['phone_number']);
				
			$testPatientId = $this->testPatientId;
		}
		echo "Patient record created\n";
		return $testPatientId;
  	}

  	/**
  	 * Tests the update function in the PatientController
     * @depends testStore
	 * @param  int $testPatientId Patient ID from testStore(), testing Sample from the constructor
	 * @return void
     */
	public function testUpdate($testPatientId)
	{
		// Update the Patient Types
		$this->runUpdate($this->input, $testPatientId);

		$patientsSaved = Patient::orderBy('id','desc')->take(1)->get();
		foreach ($patientsSaved as $patientSaved) {
			$this->testPatientId = $patientSaved->id;
			$this->assertEquals($patientSaved->patient_number, $this->inputUpdate['patient_number']);
			$this->assertEquals($patientSaved->name, $this->inputUpdate['name']);
			$this->assertEquals($patientSaved->dob, $this->inputUpdate['dob']);
			$this->assertEquals($patientSaved->gender, $this->inputUpdate['gender']);
			$this->assertEquals($patientSaved->email, $this->inputUpdate['email']);
			$this->assertEquals($patientSaved->address, $this->inputUpdate['address']);
			$this->assertEquals($patientSaved->phone_number, $this->inputUpdate['phone_number']);
		}
		echo "\nPatient record updated\n";
	}

	
	
	/**
  	 * Tests the update function in the PatientController
     * @depends testStore
	 * @param  int $testPatientId Patient ID from testStore()
	 * @return void
     */
	public function testDelete($testPatientId)
	{
		$this->runDelete($testPatientId);
		$patientsSaved = Patient::withTrashed()->orderBy('id','desc')->take(1)->get();
		foreach ($patientsSaved as $patientSaved) {
			$this->assertNotNull($patientSaved->deleted_at);
		}
		echo "\nPatient record softDeleted\n";
	    $this->removeTestData($testPatientId);
		echo "sample Patient record removed from the Database\n";
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

	/**
	 * Executes the delete function in the PatientController
	 * @param  int $id ID of Patient stored
	 * @return void
	 */
	public function runDelete($id)
	{
		$patient = new PatientController;
    	$patient->delete($id);
	}

	 /**
	  * Force delete all sample Patients from the database
	  * @param  int $id Patient ID
	  * @return void
	  */
	public function removeTestData($id)
	{
		DB::table('patient')->delete($id);
	}
}