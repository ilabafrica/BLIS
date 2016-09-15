<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;
use Config;
use Input;
use DB;
use Response;
use Auth;
use Session;
use Lang;
/**
 *Contains functions for managing patient records 
 *
 */
class PatientController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
		{
		$search = Input::get('search');

		$patients = Patient::search($search)->orderBy('id', 'desc')->paginate(config('blis.page-items'))->appends(Input::except('_token'));

		if (count($patients) == 0) {
		 	Session::flash('message', trans('terms.no-records-found'));
		}

		// Load the view and pass the patients
		return view('patient.index', compact('patients'))->withInput(Input::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create Patient
		$lastInsertId = DB::table('patients')->max('id')+1;
		return view('patient.create')->with('lastInsertId', $lastInsertId);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PatientRequest $request)
	{
		$patient = new Patient;
		$patient->patient_number = $request->patient_number;
		$patient->name = $request->name;
		$patient->gender = $request->gender;
		$patient->dob = $request->dob;
		$patient->email = $request->email;
		$patient->address = $request->address;
		$patient->phone_number = $request->phone_number;
		$patient->created_by = Auth::user()->id;

		$patient->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('terms.record-successfully-saved'))->with('active_patient', $patient ->id);
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
		return view('patient.show', compact('patient'));
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
		return view('patient.edit', compact('patient'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(PatientRequest $request, $id)
	{
		$patient = Patient::find($id);
		$patient->patient_number = $request->patient_number;
		$patient->name = $request->name;
		$patient->gender = $request->gender;
		$patient->dob = $request->dob;
		$patient->email = $request->email;
		$patient->address = $request->address;
		$patient->phone_number = $request->phone_number;
		$patient->created_by = Auth::user()->id;
		
		$patient->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('terms.record-successfully-updated'))->with('active_patient', $patient ->id);
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
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('terms.record-successfully-deleted'));
	}

	/**
	 * Return a Patients collection that meets the searched criteria as JSON.
	 *
	 * @return Response
	 */
	public function search()
	{
        return Patient::search(Input::get('text'))->take(config('blis.limit-items'))->get()->toJson();
	}
}