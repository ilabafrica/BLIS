<?php

class ReportController extends \BaseController {
	//	Begin patient report functions
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$search = Input::get('search');
		$from = Input::get('start');
		$to = Input::get('end');
		if($search||$from||$to){
			$patients = Patient::where('id', 'LIKE', '%'.$search.'%')
								->orWhere('patient_number', 'LIKE', '%'.$search.'%')
								->orWhere('name', 'LIKE', '%'.$search.'%')
								->orWhere('external_patient_number', 'LIKE', '%'.$search.'%');
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime(date('Y-m-d'))||strtotime($to)>strtotime(date('Y-m-d'))){
					Session::flash('message', 'Please check your dates range and try again!');
				}
				else{
					$patients=$patients->where(function($q) use ($from, $to){
						$q->whereHas('visits', function($q) use ($from, $to){//Filter by date created
							$q = $q->where('created_at', '>=', $from);
							(empty($to)) ? $q : $q->where('created_at', '<=', $to);
						});
					});
				}
			}
			$patients=$patients->paginate(Config::get('kblis.page-items'));
			if (count($patients) == 0) {
			 	Session::flash('message', 'Your search <b>'.$search.'</b>, did not match any patient record!');
			}
		}
		else{
			// List all the active patients
			$patients = Patient::paginate(Config::get('kblis.page-items'));
		}
		// Load the view and pass the patients
		return View::make('reports.patient.index')->with('patients', $patients);
	}

	public function viewPatientReport($id){
		$from = Input::get('start');
		$to = Input::get('end');
		$pending_tests = Input::get('pending');
		$range_visualization = Input::get('range');

		if($pending_tests||$range_visualization||$from||$to){
			$visits = Visit::where('patient_id', '=', $id);
			if($from||$to){
				if(strtotime($from)>strtotime($to)||strtotime($from)>strtotime(date('Y-m-d'))||strtotime($to)>strtotime(date('Y-m-d'))||strtotime($from)==strtotime($to)){
						Session::flash('message', 'Please check your dates range and try again!');
				}
				else{
					$visits=$visits->where('created_at', '>=', $from)->where('created_at', '<=', $to);
				}
			}
			$visits = $visits->get();
		}
		else{
			$visits = Visit::where('patient_id', '=', $id)
						->join('tests', 'visits.id', '=', 'tests.visit_id')
						->whereRaw('(tests.test_status_id = '.Test::COMPLETED.' OR tests.test_status_id = '.Test::VERIFIED.')')
						->where('visits.created_at', 'LIKE', '%'.date('Y-m-d').'%')
						->get();
		}
		$patient = Patient::find($id);
		if(Input::has('filter')){
			return View::make('reports.patient.report')->with('patient', $patient)->with('visits', $visits)->with('from', $from)->with('to', $to);
		}
		else if(Input::has('word')){
			$date = date("Ymdhi");
			$file_name = "blispatient_".$id."_".$date.".doc";
			$headers = array(
			    "Content-type"=>"text/html",
			    "Content-Disposition"=>"attachment;Filename=".$file_name
			);
			$content = View::make('reports.patient.export')->with('patient', $patient)->with('visits', $visits)->with('from', $from)->with('to', $to);
	    	return Response::make($content,200, $headers);
		}
		else if(Input::has('pdf')){
			$html = View::make('reports.patient.export')->with('patient', $patient)->with('visits', $visits)->with('from', $from)->with('to', $to);
    		return PDF::load($html, 'A4', 'portrait')->show();
		}
		else{
			return View::make('reports.patient.report')->with('patient', $patient)->with('visits', $visits)->with('from', $from)->with('to', $to);
		}
	}
	//	End patient report functions
}
