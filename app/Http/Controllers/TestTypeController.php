<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\TestTypeRequest;
use App\Models\TestType;
use App\Models\Measure;
use App\Models\MeasureType;
use App\Models\SpecimenType;
use App\Models\TestCategory;
use App\Models\Organism;
use Response;
use Auth;
use Session;
use Lang;

/**
 *Contains functions for managing test types
 *
 */
class TestTypeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active testtypes
			$testtypes = TestType::orderBy('name', 'ASC')->get();

		// Load the view and pass the testtypes
		return view('testtype.index', compact('testtypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$measures = Measure::orderBy('name')->get();
		$specimentypes = SpecimenType::orderBy('name')->get();
		$testcategories = TestCategory::lists('name', 'id');
        $measuretype = MeasureType::all()->sortBy('id');
        $organisms = Organism::orderBy('name')->get();

		//Create TestType
		return view('testtype.create', compact('testcategories', 'measures', 'measuretype', 'specimentypes', 'organisms'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TestTypeRequest $request)
	{

		$testtype = new TestType;
		$testtype->name = trim($request->name);
		$testtype->description = $request->description;
		$testtype->test_category_id = $request->test_category_id;
		$testtype->targetTAT = $request->targetTAT;
		$testtype->prevalence_threshold = $request->prevalence_threshold;
		$testtype->orderable_test = $request->orderable_test;
		$testtype->accredited = $request->accredited;

		$testtype->save();
		$measureIds = array();
		$inputNewMeasures = $request->new_measures;
		
		$measures = New MeasureController;
		$measureIds = $measures->store($inputNewMeasures);
		$testtype->setMeasures($measureIds);
		$testtype->setSpecimenTypes($request->specimentypes);
		$testtype->setOrganisms($request->organisms);
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_testtype', $testtype ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show a testtype
		$testtype = TestType::find($id);

		//Show the view and pass the $testtype to it
		return view('testtype.show', compact('testtype'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the testtype
		$testtype = TestType::find($id);
		$measures = Measure::all();
        $measuretype = MeasureType::all()->sortBy('id');
		$specimentypes = SpecimenType::orderBy('name')->get();
		$testcategory = $testtype->testCategory->id;
		$testcategories = TestCategory::lists('name', 'id');
		$organisms = Organism::orderBy('name')->get();

		//Open the Edit View and pass to it the $testtype
		return view('testtype.edit', compact('testtype', 'testcategories', 'testcategory', 'measures', 'measuretype', 'specimentypes', 'organisms'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(TestTypeRequest $request, $id)
	{
		$testtype = TestType::find($id);
		$testtype->name = trim($request->name);
		$testtype->description = $request->description;
		$testtype->test_category_id = $request->test_category_id;
		$testtype->targetTAT = $request->targetTAT;
		$testtype->prevalence_threshold = $request->prevalence_threshold;
		$testtype->orderable_test = $request->orderable_test;
		$testtype->accredited = $request->accredited;
		$testtype->save();

		$testtype->setOrganisms($request->organisms);
		$testtype->setSpecimenTypes($request->specimentypes);
		$measureIds = array();
		if ($request->new_measures) {
			$inputNewMeasures = $request->new_measures;

			$measures = New MeasureController;
			$measureIds = $measures->store($inputNewMeasures);
		}

		if ($request->measures) {
			$inputMeasures = $request->measures;
			foreach($inputMeasures as $key => $value)
			{
			  $measureIds[] = $key;
			}
			$measures = New MeasureController;
			$measures->update($inputMeasures);
		}
		$testtype->setMeasures($measureIds);
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_testtype', $testtype ->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage (soft delete).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the testtype
		$testtype = TestType::find($id);
        $inUseByTests = $testtype->tests->toArray();

		if (empty($inUseByTests)) {
		    // The test type is not in use
			$testtype->delete();
		} else {
		    // The test type is in use
		    return view('testtype.index')->with('message', 'general-terms.failure-delete-record');
		}
		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-deleted'));
	}
}