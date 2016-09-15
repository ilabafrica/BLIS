<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Requests\CriticalRequest;
use App\Models\Critical;
use Response;
use Auth;
use Session;
use Lang;

use Illuminate\Database\QueryException;

/**
 * Contains criticals resources  
 * 

SupplierRequest $request */

class CriticalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all criticals
		$criticals = Critical::orderBy('id', 'ASC')->get();
		//Load the view and pass the criticals
		return View::make('critical.index')->with('criticals', $criticals);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Get measures list
		$measures = Measure::lists('name', 'id');
		// Create critical
		return View::make('critical.create')->with('measures', $measures);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Critical $request)
	{
		//store
		$critical = new Critical;
		$critical->parameter = $request->measure_id;
		$critical->gender = $request->gender;
		$critical->age_min = $request->age_min;
		$critical->age_max = $request->age_max;
		$critical->normal_lower = $request->normal_lower;
		$critical->normal_upper = $request->normal_upper;
		$critical->critical_low = $request->critical_low;
		$critical->critical_high = $request->critical_high;
		$critical->unit = $request->unit;
		try{
			$critical->save();
			$url = session('SOURCE_URL');
        
        	return redirect()->to($url)
				->with('message', trans('messages.record-successfully-saved')) ->with('activecritical', $critical ->id);
		}catch(QueryException $e){
			Log::error($e);
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a critical
		$critical = Critical::find($id);
		//show the view and pass the $critical to it
		return View::make('critical.show')->with('critical', $critical);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// Get measures list
		$measures = Measure::lists('name', 'id');
		//Get the critical
		$critical = Critical::find($id);

		//Open the Edit View and pass to it the $critical
		return View::make('critical.edit')->with('critical', $critical)->with('measures', $measures);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Critical $request, $id)
	{
		// Update
		$critical = Critical::find($id);
		$critical->parameter = $request->measure_id;
		$critical->gender = $request->gender;
		$critical->age_min = $request->age_min;
		$critical->age_max = $request->age_max;
		$critical->normal_lower = $request->normal_lower;
		$critical->normal_upper = $request->normal_upper;
		$critical->critical_low = $request->critical_low;
		$critical->critical_high = $request->critical_high;
		$critical->unit = $request->unit;
		$critical->save();

		// redirect
		$url = session('SOURCE_URL');
        
        return redirect()->to($url)
			->with('message', trans('messages.record-successfully-updated')) ->with('activetestcategory', $critical ->id);
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
		//Soft delete the critical
		$critical = Critical::find($id);

		/*$testCategoryInUse = TestType::where('test_category_id', '=', $id)->first();
		if (empty($testCategoryInUse)) {
		    // The test category is not in use
			$testcategory->delete();
		} else {
		    // The test category is in use
		    $url = session('SOURCE_URL');
            
            return redirect()->to($url)
		    	->with('message', trans('messages.failure-test-category-in-use'));
		}*/
		// redirect
			$url = session('SOURCE_URL');
            
            return redirect()->to($url)
			->with('message', trans('messages.record-successfully-deleted'));
	}
}
