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
		$this->withoutMiddleware();

		$facilityName = 'TEL AVIV MEDICAL CENTRE';
		$this->call('POST', '/facility', ['name' => $facilityName]);

		$facility = Facility::orderBy('id', 'desc')->first();
		$this->assertEquals($facilityName, $facility->name);
	}

	public function testStoreFailValidation()
	{
		$this->withoutMiddleware();
		//Check if it prevents blank name entries
		$facilityNameEmpty = '';
		$this->call('POST', '/facility', ['name' => $facilityNameEmpty]);
		$this->assertRedirectedToRoute('facility.index');
		$this->assertSessionHasErrors('name');

		$this->withoutMiddleware();
		//Check if it prevents duplicate name entries
		$facilityNameDuplicate = Facility::find(1)->name;
		$this->call('POST', '/facility', ['name' => $facilityNameDuplicate]);
		$this->assertRedirectedToRoute('facility.index');
		$this->assertSessionHasErrors('name');
	}

	public function testEdit()
	{
		$facilityName = "LIKUD GILAT HOSPITAL";
		$idToUpdate = 1;
		$this->withoutMiddleware();
		$this->call('PUT', '/facility/'.$idToUpdate, ['id' => $idToUpdate, 'name' => $facilityName]);
		$faciltyNameUpdated = Facility::find($idToUpdate)->name;

		$this->assertEquals($facilityName, $faciltyNameUpdated);
	}

	public function testEditFailValidation()
	{
		//Prevents blank entries
		$facilityName = "";
		$idToUpdate = 1;
		$this->withoutMiddleware();
		$this->call('PUT', '/facility/'.$idToUpdate, ['id' => $idToUpdate, 'name' => $facilityName]);
		$this->assertRedirectedToRoute('facility.index');
		$this->assertSessionHasErrors('name');

		//Prevents duplicate entries
		$facilityName = Facility::find(2)->name;
		$idToUpdate = 1;
		$this->withoutMiddleware();
		$this->call('PUT', '/facility/{id}', ['id' => $idToUpdate, 'name' => $facilityName]);
		$this->assertRedirectedToRoute('facility.index');
		$this->assertSessionHasErrors('name');
	}

	public function testStoreDelete()
	{

		$this->call('GET', '/facility/1/delete');

		$facilityDeleted = Facility::find(1);

		$this->assertEquals(null, $facilityDeleted);
	}
}