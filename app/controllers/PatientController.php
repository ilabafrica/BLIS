<?php

use Illuminate\Database\QueryException;

/**
 *Contains functions for managing patient records 
 *
 */
class PatientController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the patients
		return View::make('patient.index')->with('patients', $patients);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create Patient
		return View::make('patient.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
		$rules = array(
			'patient_number' => 'required|unique:patients,patient_number',
			'name'       => 'required',
			'gender' => 'required',
			'dob' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$patient = new Patient;
			$patient->patient_number = Input::get('patient_number');
			$patient->name = Input::get('name');
			$patient->gender = Input::get('gender');
			$patient->dob = Input::get('dob');
			$patient->email = Input::get('email');
			$patient->address = Input::get('address');
			$patient->phone_number = Input::get('phone_number');

			try{
				$patient->save();
				return Redirect::to('patient')->with('message', 'Successfully created patient!');
			}catch(QueryException $e){
				Log::error($e);
			}
			
			// redirect
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
		//Show a patient
		$patient = Patient::find($id);

		//Show the view and pass the $patient to it
		return View::make('patient.show')->with('patient', $patient);
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
		$patient = Patient::find($id);

		//Open the Edit View and pass to it the $patient
		return View::make('patient.edit')->with('patient', $patient);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$rules = array(
			'patient_number' => 'required',
			'name'       => 'required',
			'gender' => 'required',
			'dob' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('patient/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// Update
			$patient = Patient::find($id);
			$patient->patient_number = Input::get('patient_number');
			$patient->name = Input::get('name');
			$patient->gender = Input::get('gender');
			$patient->dob = Input::get('dob');
			$patient->email = Input::get('email');
			$patient->address = Input::get('address');
			$patient->phone_number = Input::get('phone_number');
			$patient->save();

			// redirect
			return Redirect::to('patient')->with('message', 'The patient details were successfully updated!');
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
		//Soft delete the patient
		$patient = Patient::find($id);

		$patient->delete();

		// redirect
		return Redirect::to('patient')->with('message', 'The patient was successfully deleted!');
	}

	/**
	 * Return a Patients collection that meets the searched criteria as JSON.
	 *
	 * @return Response
	 */
	public function search()
	{
        return Patient::select('id', 'patient_number','name')
                ->where(function($query){
                    $txt = Input::get('text');
                    $query->where("name", "LIKE", "%".$txt."%")
                        ->orWhere("patient_number", "LIKE", "%".$txt."%");
                })->get()->toJson();
	}

}