<?php
use Illuminate\Database\QueryException;

/**
 * Contains bbs resources  
 * 
 */
class BloodController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all bbs
		$bbs = Blood::orderBy('bag_number', 'ASC')->get();
		//Load the view and pass the bbs
		return View::make('blood.index')->with('bbs',$bbs);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create bb
		$groups = array(Blood::ONEGATIVE => 'O-', Blood::OPOSITIVE => 'O+', Blood::ANEGATIVE => 'A-', Blood::APOSITIVE => 'A+', Blood::BNEGATIVE => 'B-', Blood::BPOSITIVE => 'B+', Blood::ABNEGATIVE => 'AB-', Blood::ABPOSITIVE => 'AB+');
		return View::make('blood.create')->with('groups', $groups);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('bag_number' => 'required|unique:blood_bank,bag_number');
		$rules = array('blood_group' => 'required:blood_bank,blood_group');
		$rules = array('volume' => 'required:blood_bank,volume');
		$rules = array('date_collected' => 'required:blood_bank,date_collected');
		$rules = array('expiry_date' => 'required:blood_bank,expiry_date');
		$validator = Validator::make(Input::all(), $rules);
	
		//process
		if($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}else{
			//store
			$bb = new Blood;
			$bb->bag_number = Input::get('bag_number');
			$bb->blood_group = Input::get('blood_group');
			$bb->volume = Input::get('volume');
			$bb->date_collected = Input::get('date_collected');
			$bb->expiry_date = Input::get('expiry_date');
			try{
				$bb->save();
				$url = Session::get('SOURCE_URL');
            
            	return Redirect::to($url)
					->with('message', trans('messages.record-successfully-saved')) ->with('activebb', $bb ->id);
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
		//show a bb
		$bb = Blood::find($id);
		//show the view and pass the $bb to it
		return View::make('blood.show')->with('bb',$bb);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the bb
		$bb = Blood::find($id);
		$groups = array(Blood::ONEGATIVE => 'O-', Blood::OPOSITIVE => 'O+', Blood::ANEGATIVE => 'A-', Blood::APOSITIVE => 'A+', Blood::BNEGATIVE => 'B-', Blood::BPOSITIVE => 'B+', Blood::ABNEGATIVE => 'AB-', Blood::ABPOSITIVE => 'AB+');
		$group = $bb->blood_group;
		//Open the Edit View and pass to it the $bb
		return View::make('blood.edit')->with('bb', $bb)->with('groups', $groups)->with('group', $group);
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
		$rules = array('bag_number' => 'required|unique:blood_bank,bag_number');
		$rules = array('blood_group' => 'required:blood_bank,blood_group');
		$rules = array('volume' => 'required:blood_bank,volume');
		$rules = array('date_collected' => 'required:blood_bank,date_collected');
		$rules = array('expiry_date' => 'required:blood_bank,expiry_date');
		$validator = Validator::make(Input::all(), $rules);
	
		//process
		if($validator->fails()){
			return Redirect::back()->withErrors($validator);
		}else{
			//store
			$bb = Blood::find($id);
			$bb->bag_number = Input::get('bag_number');
			$bb->blood_group = Input::get('blood_group');
			$bb->volume = Input::get('volume');
			$bb->date_collected = Input::get('date_collected');
			$bb->expiry_date = Input::get('expiry_date');
			$bb->save();

			// redirect
			$url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
				->with('message', trans('messages.record-successfully-updated')) ->with('activebb', $bb ->id);
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
		//Soft delete the bb
		$bb = Blood::find($id);

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
