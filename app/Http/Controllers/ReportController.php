<?php

namespace App\Http\Controllers;
set_time_limit(0); //60 seconds = 1 minute

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Patient;
use App\Models\TestCategory;
use App\Models\Test;
use App\Models\ReportDisease;
use App\Models\Disease;
use App\Models\Visit;
use App\Models\Specimen;
use App\Models\TestType;
use App\Models\TestTypeMeasure;
use App\Models\TestResult;
use App\Models\Measure;
use App\Models\SpecimenType;
use App\Models\Control;
use App\Models\Receipt;
use App\Models\User;

use Input;
use Response;
use Config;
use DateTime;
use Session;
use DB;
use Lang;
use Jenssegers\Date\Date as Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadPatients()
    {
        $search = Input::get('search');

        $patients = Patient::search($search)->orderBy('id','DESC')->paginate(Config::get('blis.page-items'));

        if (count($patients) == 0) {
            Session::flash('message', trans('messages.no-match'));
        }

        // Load the view and pass the patients
        return view('report.daily.patient.index', compact('patients'))->withInput(Input::all());
    }

    /**
     * Display data after applying the filters on the report uses patient ID
     *
     * @return Response
     */
    public function viewPatientReport($id, $visit = null){
        $from = Carbon::parse(Input::get('from'));
        $to = Carbon::parse(Input::get('to'));
        $pending = Input::get('pending');
        $date = Carbon::today();
        $error = '';
        $visitId = Input::get('visit_id');
        //  Check checkbox if checked and assign the 'checked' value
        if (Input::get('tests') === '1') {
            $pending='checked';
        }
        //  Query to get tests of a particular patient
        if(($visit || $visitId) && $id){
            $tests = Test::where('visit_id', '=', $visit?$visit:$visitId);
        }
        else{
            $tests = Test::join('visits', 'visits.id', '=', 'tests.visit_id')
                            ->where('patient_id', '=', $id);
        }
        //  Begin filters - include/exclude pending tests
        if($pending){
            $tests=$tests->where('tests.test_status_id', '!=', Test::NOT_RECEIVED);
        }
        else{
            $tests = $tests->whereIn('tests.test_status_id', [Test::COMPLETED, Test::VERIFIED]);
        }
        //  Date filters
        if($from||$to){

            if(!$to) $to = $date;

            if($from->gt($to) || $from->gt($date) || $to->gt($date)){
                    $error = trans('general-terms.check-date-range');
            }
            else
            {
                $toPlusOne = $to->addDay();
                $tests=$tests->whereBetween('time_created', [$from->toDateTimeString(), $toPlusOne->toDateTimeString()]);
            }
        }
        //  Get tests collection
        $tests = $tests->get(array('tests.*'));
        //  Get patient details
        $patient = Patient::find($id);
        //  Check if tests are accredited
        $accredited = array();
        $verified = array();
        foreach ($tests as $test)
        {
            if($test->testType->isAccredited())
                array_push($accredited, $test->id);
            else
                continue;
        }
        foreach ($tests as $test)
        {
            if($test->isVerified())
                array_push($verified, $test->id);
            else
                continue;
        }
        if(Input::has('word'))
        {
            $date = date("Ymdhi");
            $fileName = "blispatient_".$id."_".$date.".doc";
            $headers = array(
                "Content-type"=>"text/html",
                "Content-Disposition"=>"attachment;Filename=".$fileName
            );
            $content = view('report.daily.patient.export', compact('patient', 'tests', 'from', 'to', 'visit', 'accredited'));
            return Response::make($content, 200, $headers);
        }
        else
        {
            $to = $to->toDateString();
            $from = $from->toDateString();
            return view('report.daily.patient.report', compact('patient', 'tests', 'pending', 'error', 'visit', 'accredited', 'verified', 'from', 'to'))->withInput(Input::all());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
