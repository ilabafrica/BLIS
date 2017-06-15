<?php
use Illuminate\Database\QueryException;

/**
 * Contains criticals resources  
 * 
 */
class CriticalController extends \BaseController {

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
		//	Get units
		$units = [Critical::DAYS => "Days", Critical::MONTHS => "Months", Critical::YEARS => "Years"];
		// Create critical
		return View::make('critical.create')->with('measures', $measures)->with('units', $units);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('measure_id' => 'required:critical,parameter');
		$validator = Validator::make(Input::all(), $rules);
	
		//process
		if($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}else{
			//store
			$critical = new Critical;
			$critical->parameter = Input::get('measure_id');
			$critical->gender = Input::get('gender');
			$critical->age_min = Input::get('age_min');
			$critical->age_max = Input::get('age_max');
			$critical->normal_lower = Input::get('normal_lower');
			$critical->normal_upper = Input::get('normal_upper');
			$critical->critical_low = Input::get('critical_low');
			$critical->critical_high = Input::get('critical_high');
			$critical->unit = Input::get('unit');
			$critical->age_unit = Input::get('age_unit');
			try{
				$critical->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.record-successfully-saved')) ->with('activecritical', $critical ->id);
			}catch(QueryException $e){
				Log::error($e);
			}
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
		
		//	Get units
		$units = [Critical::DAYS => "Days", Critical::MONTHS => "Months", Critical::YEARS => "Years"];
		//Open the Edit View and pass to it the $critical
		return View::make('critical.edit')->with('critical', $critical)->with('measures', $measures)->with('units', $units);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Validate
		$rules = array('measure_id' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// Update
			$critical = Critical::find($id);
			$critical->parameter = Input::get('measure_id');
			$critical->gender = Input::get('gender');
			$critical->age_min = Input::get('age_min');
			$critical->age_max = Input::get('age_max');
			$critical->normal_lower = Input::get('normal_lower');
			$critical->normal_upper = Input::get('normal_upper');
			$critical->critical_low = Input::get('critical_low');
			$critical->critical_high = Input::get('critical_high');
			$critical->unit = Input::get('unit');
			$critical->age_unit = Input::get('age_unit');
			$critical->save();

			// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
				->with('message', trans('messages.record-successfully-updated')) ->with('activetestcategory', $critical ->id);
		}
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
		    $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
		    	->with('message', trans('messages.failure-test-category-in-use'));
		}*/
		// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
			->with('message', trans('messages.record-successfully-deleted'));
	}
}