<?php

class CustomFieldController extends \BaseController {

/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$customFields = CustomField::orderBy('id')->get();
		return View::make('customfield.index')->with('customfields', $customFields);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$customfieldTypes = CustomFieldType::lists('name', 'id');
		return View::make('customfield.create')->with('customfieldTypes', $customfieldTypes);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation -checking that name is unique among the un soft-deleted ones
		$rules = array('name' => 'required|unique:custom_fields,name,NULL,id,deleted_at,null',
					'label' => 'required',
					'customfieldtype' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::route('customfield.create')->withErrors($validator)->withInput();
		} else {
			// Add
			$customfield = new CustomField;
			$customfield->name = Input::get('name');
			$customfield->label = Input::get('label');
			$customfield->custom_field_type_id = Input::get('customfieldtype');
			$customfield->save();
			// redirect
			return Redirect::to('customfield')
					->with('message', "The custom field was succesfuly added");
					// ->with('activeControl', $control ->id);
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
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$customfieldTypes = CustomFieldType::lists('name', 'id');
		$customField = CustomField::find($id);
		
		return View::make('customfield.edit')->with('customfieldTypes', $customfieldTypes)->with('customField', $customField);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'name' => 'required|unique:custom_fields,name,NULL,id,deleted_at,null',
			'label' => 'required',
			'customfieldtype' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			// Update
			$customfield = CustomField::find($id);
			$customfield->name = Input::get('name');
			$customfield->label = Input::get('label');
			$customfield->custom_field_type_id = Input::get('customfieldtype');
			$customfield->save();

			// redirect
			return Redirect::back()->with('message', "Custom Fields updated");
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
		//Delete the CF
		$customfield = CustomField::find($id);
		$customfield->delete();
		// redirect
		return Redirect::route('customfield.index')->with('message', "Successfully deleted custom field");
	}
}