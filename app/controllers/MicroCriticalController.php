<?php
use Illuminate\Database\QueryException;

/**
 * Contains microcriticals resources  
 * 
 */
class MicroCriticalController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all microcriticals
		$microcritical = MicroCritical::orderBy('id', 'ASC')->get();
		//Load the view and pass the microcriticals
		return View::make('microcritical.index')->with('microcritical', $microcritical);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create microcritical
		return View::make('microcritical.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('description' => 'required|unique:micro_critical,description');
		$validator = Validator::make(Input::all(), $rules);
	
		//process
		if($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}else{
			//store
			$microcritical = new MicroCritical;
			$microcritical->description = Input::get('description');
			try{
				$microcritical->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.record-successfully-saved')) ->with('activemicrocritical', $microcritical ->id);
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
		//show a microcritical
		$microcritical = MicroCritical::find($id);
		//show the view and pass the $microcritical to it
		return View::make('microcritical.show')->with('microcritical',$microcritical);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the microcritical
		$microcritical = MicroCritical::find($id);

		//Open the Edit View and pass to it the $microcritical
		return View::make('microcritical.edit')->with('microcritical', $microcritical);
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
		$rules = array('name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// Update
			$microcritical = MicroCritical::find($id);
			$microcritical->description = Input::get('description');
			$microcritical->save();

			// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
				->with('message', trans('messages.record-successfully-updated')) ->with('activetestcategory', $microcritical ->id);
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
		//Soft delete the microcritical
		$microcritical = MicroCritical::find($id);

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