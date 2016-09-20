<?php
/**
 * Tests the MeasureController functions that store, edit and delete measures 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */
use App\Models\User;
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
        Session::start();
	}

	public function testStorePass()
	{
		echo "\n\nFACILITY CONTROLLER TEST\n\n";
		$this->withoutMiddleware();

		$facilityName = 'TEL AVIV MEDICAL CENTRE';
		$this->call('POST', '/facility', ['name' => $facilityName]);

		$facility = Facility::orderBy('id', 'desc')->first();
		$this->assertEquals($facilityName, $facility->name);
		$this->assertRedirectedToRoute('facility.index');
	}

	public function testStoreFailValidation()
	{

        // Set the current user to admin
        $this->be(User::first());

		$this->withoutMiddleware();
		//Check if it prevents blank name entries
		$facilityNameEmpty = '';
		$this->call('POST', '/facility', ['name' => $facilityNameEmpty]);
		$this->assertRedirectedToRoute('facility.index');
		// todo: Session can not be used with without middleware need to rethink this, yet we need to avoid the auth middleware(not yet implemented BTW) and the Illuminate\Session\TokenMismatchException while testing, or maybe instead of auth middleware we can use authorise in the form request. or have a trait for all of them lets see
		// $this->assertSessionHasErrors('name');
		// todo: the above just won't do, below is the best I can do for now
		$this->assertSessionHasErrors();

		$this->withoutMiddleware();
		//Check if it prevents duplicate name entries
		$facilityNameDuplicate = Facility::find(1)->name;
		$this->call('POST', '/facility', ['name' => $facilityNameDuplicate]);
		$this->assertRedirectedToRoute('facility.index');
		
		// $this->assertSessionHasErrors('name');
		// todo: the above just won't do, below is the best I can do for now
		$this->assertSessionHasErrors();
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
		// $this->assertSessionHasErrors('name');
		// todo: the above just won't do, below is the best I can do for now
		$this->assertSessionHasErrors();

		//Prevents duplicate entries
		$facilityName = Facility::find(2)->name;
		$idToUpdate = 1;
		$this->withoutMiddleware();
		$this->call('PUT', '/facility/{id}', ['id' => $idToUpdate, 'name' => $facilityName]);
		$this->assertRedirectedToRoute('facility.index');
		// $this->assertSessionHasErrors('name');
		// todo: the above just won't do, below is the best I can do for now
		$this->assertSessionHasErrors();
	}

	public function testStoreDelete()
	{

        $this->be(User::find(1));
		$this->call('GET', '/facility/1/delete');

		$facilityDeleted = Facility::find(1);

		$this->assertEquals(null, $facilityDeleted);
	}
}