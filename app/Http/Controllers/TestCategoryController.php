<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\TestCategoryRequest;

use App\Models\TestCategory;

use Response;
use Auth;
use Session;
use Lang;

/**
 * Contains test categories a.k.a lab sections
 * A classification of test types
 */
class TestCategoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all test categories
		$testcategory = TestCategory::orderBy('name', 'ASC')->get();
		//Load the view and pass the test categories
		return view('testcategory.index')->with('testcategory',$testcategory);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create test category
		return view('testcategory.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TestCategoryRequest $request)
	{
		$testCategory = new TestCategory;
		$testCategory->name = $request->name;
		$testCategory->description = $request->description;
		$testCategory->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_testCategory', $testCategory ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a test category
		$testcategory = TestCategory::find($id);
		//show the view and pass the $testcategory to it
		return view('testcategory.show')->with('testcategory',$testcategory);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the patient
		$testcategory = TestCategory::find($id);

		//Open the Edit View and pass to it the $patient
		return view('testcategory.edit')->with('testcategory', $testcategory);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(TestCategoryRequest $request, $id)
	{
		$testCategory = TestCategory::find($id);
		$testCategory->name = $request->name;
		$testCategory->description = $request->description;
		$testCategory->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_testCategory', $testCategory ->id);
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
		//Soft delete the test category
		$testcategory = TestCategory::find($id);

		$testCategoryInUse = TestType::where('test_category_id', '=', $id)->first();
		if (empty($testCategoryInUse)) {
		    // The test category is not in use
			$testcategory->delete();
		} else {
		    // The test category is in use
		    $url = session('SOURCE_URL');
            
            return redirect()->to($url)->with('message', trans('messages.failure-test-category-in-use'));
		}
		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}