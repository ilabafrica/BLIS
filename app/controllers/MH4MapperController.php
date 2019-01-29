<?php

class MH4MapperController extends Controller
{
	public static function index()
    {
    	$mappings = EmrTestTypeAlias::orderBy('emr_alias', 'desc')->with('TestType', 'MH4Mapper')->paginate(Config::get('kblis.page-items'))->appends(Input::except('_token'));
		return View::make('mh4lmapper.index')->with('mappings',$mappings);
	}

	public function create()
	{	
		$testtypes = TestType::orderBy('name', 'asc')->get();
		$mh4lmapper = MH4Mapper::orderBy('name', 'asc')->get();
		//Create Mapping
		return View::make('mh4lmapper.create')->with('testtypes',$testtypes)->with('mh4lmapper',$mh4lmapper);
	}

	public function store()
	{
		//
		$rules = array(
			'blistest' 			=> 'required',
			'mhealthequivalent' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Redirect::back()->withErrors($validator)->withInput(Input::all());
		} else {
			// store
			$emrTestTypeAlias = new EmrTestTypeAlias;
			$emrTestTypeAlias->client_id = 1;
			$emrTestTypeAlias->emr_alias = Input::get('mhealthequivalent');
			$emrTestTypeAlias->test_type_id = Input::get('blistest');

			try{
				$emrTestTypeAlias->save();
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
			->with('message', 'Successfully created mapping!');
			}catch(QueryException $e){
				Log::error($e);
			}
			
			// redirect
		}
	}

	public function edit($id)
	{
		$testtypes = TestType::orderBy('name', 'asc')->get();
		$mh4lmapper = MH4Mapper::orderBy('name', 'asc')->get();
		//Get the mapping
		$emrTestTypeAlias = EmrTestTypeAlias::find($id);

		//Open the Edit View and pass to it the $patient
		return View::make('mh4lmapper.edit')->with('emrTestTypeAlias', $emrTestTypeAlias)->with('testtypes',$testtypes)->with('mh4lmapper',$mh4lmapper);
	}

	public function update($id)
	{
		//
		$rules = array(
			'blistest' 			=> 'required',
			'mhealthequivalent' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('mh4lmapper/' . $id . '/edit')
				->withErrors($validator);
		} else {
			// Update
			$emrTestTypeAlias = EmrTestTypeAlias::find($id);
			$emrTestTypeAlias->emr_alias = Input::get('mhealthequivalent');
			$emrTestTypeAlias->test_type_id = Input::get('blistest');
			$emrTestTypeAlias->save();

			// redirect
			$url = Session::get('SOURCE_URL');
			return Redirect::to($url)
			->with('message', 'The mapping details were successfully updated!');

		}
	}

	public function delete($id)
	{
		//Soft delete the EmrTestTypeAlias
		$emrTestTypeAlias = EmrTestTypeAlias::find($id);

		$emrTestTypeAlias->delete();

		// redirect
			$url = Session::get('SOURCE_URL');
			return Redirect::to('mh4lmapper')
			->with('message', 'The mapping was successfully deleted!');
	}

}