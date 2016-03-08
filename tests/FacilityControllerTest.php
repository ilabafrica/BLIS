<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\Facility;
use App\Http\Controllers\FacilityController;
class FacilityControllerTest extends TestCase 
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
	}

	public function testStorePass()
	{
		echo "\n\nFACILITY CONTROLLER TEST\n\n";

		$facilityName = 'TEL AVIV MEDICAL CENTRE';
		$this->action('POST', 'FacilityController@store', array('name' => $facilityName));

		$facility = Facility::orderBy('id', 'desc')->first();

		$this->assertEquals($facilityName, $facility->name);
	}

	public function testStoreFailValidation()
	{
		//Check if it prevents blank name entries
		$facilityNameEmpty = '';
		Input::replace(array('name' => $facilityNameEmpty));
		$facilityController = new FacilityController;
		$facilityController->store();

		$this->assertRedirectedToRoute('facility.index');
		$this->assertSessionHasErrors('name');

		//Check if it prevents duplicate name entries
		$facilityNameDuplicate = Facility::find(1)->name;
		Input::replace(array('name' => $facilityNameDuplicate));
		$facilityController = new FacilityController;
		$facilityController->store();

		$this->assertRedirectedToRoute('facility.index');
		$this->assertSessionHasErrors('name');
	}

	public function testEdit()
	{
		$facilityName = "LIKUD GILAT HOSPITAL";
		$idToUpdate = 1;
		Input::replace(array('id' => $idToUpdate, 'name' => $facilityName));
		$facilityController = new FacilityController;
		$facilityController->update();

		$faciltyNameUpdated = Facility::find($idToUpdate)->name;

		$this->assertEquals($facilityName, $faciltyNameUpdated);
	}

	public function testEditFailValidation()
	{
		//Prevents blank entries
		$facilityName = "";
		$idToUpdate = 1;
		Input::replace(array('id' => $idToUpdate, 'name' => $facilityName));
		$facilityController = new FacilityController;
		$facilityController->update();

		$this->assertRedirectedToRoute('facility.index');
		$this->assertSessionHasErrors('name');

		//Prevents duplicate entries
		$facilityName = Facility::find(2)->name;
		$idToUpdate = 1;
		Input::replace(array('id' => $idToUpdate, 'name' => $facilityName));
		$facilityController = new FacilityController;
		$response = $facilityController->update();

		$this->assertRedirectedToRoute('facility.index');
		$this->assertSessionHasErrors('name');
	}

	public function testStoreDelete()
	{
		$this->action('GET', 'FacilityController@delete', array('id' => 1));

		$facilityDeleted = Facility::find(1);

		$this->assertEquals(null, $facilityDeleted);
	}
}