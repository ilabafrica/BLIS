<?php
use Illuminate\Database\QueryException;

/**
 * Contains drugs resources  
 * 
 */
class DrugController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all drugs
		$drugs = Drug::orderBy('name', 'ASC')->get();
		//Load the view and pass the drugs
		return View::make('drug.index')->with('drugs',$drugs);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create drug
		return View::make('drug.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('name' => 'required|unique:drugs,name');
		$rules = array('abbreviation' => 'required|unique:drugs,abbreviation');
		$validator = Validator::make(Input::all(), $rules);
	
		//process
		if($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}else{
			//store
			$drug = new Drug;
			$drug->name = Input::get('name');
			$drug->abbreviation = Input::get('abbreviation');
			$drug->description = Input::get('description');
			try{
				$drug->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.success-creating-drug')) ->with('activedrug', $drug ->id);
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
		//show a drug
		$drug = Drug::find($id);
		//show the view and pass the $drug to it
		return View::make('drug.show')->with('drug',$drug);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the drug
		$drug = Drug::find($id);

		//Open the Edit View and pass to it the $drug
		return View::make('drug.edit')->with('drug', $drug);
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
		$rules = array('abbreviation' => 'required|unique:drugs,abbreviation');
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
		} else {
			// Update
			$drug = Drug::find($id);
			$drug->name = Input::get('name');
			$drug->abbreviation = Input::get('abbreviation');
			$drug->description = Input::get('description');
			$drug->save();

			// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
				->with('message', trans('messages.success-updating-drug')) ->with('activedrug', $drug ->id);
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
		//Soft delete the drug
		$drug = Drug::find($id);

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
			->with('message', trans('messages.success-deleting-drug'));
	}
}
