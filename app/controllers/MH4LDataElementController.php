<?php

class MH4LDataElementController extends Controller
{
	public static function index()
	{
		$dataElements = MH4Mapper::orderBy('name', 'asc')->paginate(Config::get('kblis.page-items'))->appends(Input::except('_token'));
		return View::make('mh4lmapper.mh4ldataelement.index')->with('dataElements',$dataElements);
	}

	public function create()
	{	
		return View::make('mh4lmapper.mh4ldataelement.create');
	}

	public function store()
	{
		$rules = array(
			'name' 			=> 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {

			return Redirect::back()->withErrors($validator)->withInput(Input::all());
		} else {
			// store
			$mH4LDataElement = new MH4Mapper;
			$mH4LDataElement->name = Input::get('name');
			$mH4LDataElement->ndata_element_id = Input::get('data_element_id');

			try{
				$mH4LDataElement->save();
				$url = Session::get('SOURCE_URL');

				return Redirect::to($url)
					->with('message', 'Successfully created mapping!');
			}catch(QueryException $e){
				Log::error($e);
			}
		}
	}

	public function delete($id)
	{
		//Soft delete the mH4LDataElement
		$mH4LDataElement = MH4Mapper::find($id);

		$mH4LDataElement->delete();

		$url = Session::get('SOURCE_URL');
		return Redirect::to('mh4ldataelement')
			->with('message', 'The mapping was successfully deleted!');
	}

}