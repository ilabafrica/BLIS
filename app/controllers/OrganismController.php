<?php

class OrganismController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all organisms
		$organisms = Organism::orderBy('name', 'ASC')->get();
		//Load the view and pass the organisms
		return View::make('organism.index')->with('organisms',$organisms);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$drugs = Drug::orderBy('name')->get();
		//Create organism
		return View::make('organism.create')->with('drugs', $drugs);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('name' => 'required|unique:organisms,name');
		$validator = Validator::make(Input::all(), $rules);
	
		//process
		if($validator->fails()){
			return Redirect::back()->withErrors($validator)->WithInput();
		}else{
			//store
			$organism = new Organism;
			$organism->name = Input::get('name');
			$organism->description = Input::get('description');
			try{
				$organism->save();
				if(Input::get('drugs')){
					$organism->setDrugs(Input::get('drugs'));
				}
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.success-creating-organism')) ->with('activeorganism', $organism ->id);
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
		//show a organism
		$organism = Organism::find($id);
		//show the view and pass the $organism to it
		return View::make('organism.show')->with('organism',$organism);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$drugs = Drug::orderBy('name')->get();
		//Get the organism
		$organism = Organism::find($id);

		//Open the Edit View and pass to it the $organism
		return View::make('organism.edit')
					->with('organism', $organism)
					->with('drugs', $drugs);
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
			return Redirect::back()->withErrors($validator);
		} else {
			// Update
			$organism = Organism::find($id);
			$organism->name = Input::get('name');
			$organism->description = Input::get('description');
			try{
				$organism->save();
				if(Input::get('drugs')){
					$organism->setDrugs(Input::get('drugs'));
				}
			}catch(QueryException $e){
				Log::error($e);
			}

			// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
				->with('message', trans('messages.success-updating-organism')) ->with('activeorganism', $organism ->id);
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
		//Soft delete the organism
		$organism = Organism::find($id);

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
			->with('message', trans('messages.success-deleting-organism'));
	}
}