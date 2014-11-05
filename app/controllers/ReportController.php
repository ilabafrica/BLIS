<?php

class ReportController extends \BaseController {
	//	Begin patient report functions
	/**
	 * Display a listing of the resource.
	 * Called loadPatients because the same controller shall be used for all other reports
	 * @return Response
	 */
	public function loadPatients()
	{
		$search = Input::get('search');
		$from = Input::get('start');
		$to = Input::get('end');
		if($search||$from||$to){
			$patients = Patient::where('id', 'LIKE', '%'.$search.'%')
								->orWhere('patient_number', 'LIKE', '%'.$search.'%')
								->orWhere('name', 'LIKE', '%'.$search.'%')
								->orWhere('external_patient_number', 'LIKE', '%'.$search.'%');
			$patients=$patients->paginate(Config::get('kblis.page-items'));
			if (count($patients) == 0) {
			 	Session::flash('message', 'Your search <b>'.$search.'</b>, did not match any patient record!');
			}
			else{
				Session::flash('message', 'Your search <b>'.$search.'</b>, matched the following patient records.');
			}
		}
		else{
			// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));
		}
		// Load the view and pass the patients
		return View::make('reports.patient.index')->with('patients', $patients);
	}
	/**
	 * Display data after applying the filters on the report uses patient ID
	 *
	 * @return Response
	 */
	public function viewPatientReport($id){
		$from = Input::get('start');
		$to = Input::get('end');
		$pending = Input::get('tests');
		//	Check checkbox if checked and assign the 'checked' value
		if (Input::get('tests') === '1') {
		    $pending='checked';
		}
		if($pending||$from||$to){
			$tests = Test::select('tests.id','test_type_id', 'specimen_id', 'interpretation', 'test_status_id', 'created_by', 'tested_by', 'verified_by', 'time_created', 'time_started', 'time_completed', 'time_verified')
						->join('visits', 'visits.id', '=', 'tests.visit_id')
						->where('patient_id', '=', $id);
			if(!$pending){
				$tests=$tests->whereRaw('(tests.test_status_id = '.Test::COMPLETED.' OR tests.test_status_id = '.Test::VERIFIED.')');
			}
			if($from||$to){
				if(!$to){
					$to = date('Y-m-d');
				}
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime(date('Y-m-d'))||strtotime($to)>strtotime(date('Y-m-d'))){
						Session::flash('error', 'Please check your dates range and try again!');
				}
				else{
					$tests=$tests->whereRaw('tests.time_created BETWEEN '."'".$from."'".' AND DATE_ADD('."'".$to."'".', INTERVAL 1 DAY)');
				}
			}
			$tests = $tests->get();
		}
		else{
			$tests = Test::select('tests.id','test_type_id', 'specimen_id', 'interpretation', 'test_status_id', 'created_by', 'tested_by', 'verified_by', 'time_created', 'time_started', 'time_completed', 'time_verified')
						->join('visits', 'visits.id', '=', 'tests.visit_id')
						->where('patient_id', '=', $id)
						->whereRaw('(tests.test_status_id = '.Test::COMPLETED.' OR tests.test_status_id = '.Test::VERIFIED.')')
						->where('tests.time_created', 'LIKE', '%'.date('Y-m-d').'%')
						->get();
		}
		$patient = Patient::find($id);
		if(Input::has('filter')){
			return View::make('reports.patient.report')
						->with('patient', $patient)
						->with('tests', $tests)
						->with('from', $from)
						->with('to', $to)
						->with('pending', $pending);
		}
		else if(Input::has('word')){
			$date = date("Ymdhi");
			$file_name = "blispatient_".$id."_".$date.".doc";
			$headers = array(
			    "Content-type"=>"text/html",
			    "Content-Disposition"=>"attachment;Filename=".$file_name
			);
			$content = View::make('reports.patient.export')
							->with('patient', $patient)
							->with('tests', $tests)
							->with('from', $from)
							->with('to', $to);
	    	return Response::make($content,200, $headers);
		}
		else{
			return View::make('reports.patient.report')
						->with('patient', $patient)
						->with('tests', $tests)
						->with('from', $from)
						->with('to', $to)
						->with('pending', $pending);
		}
	}
	//	End patient report functions
}
