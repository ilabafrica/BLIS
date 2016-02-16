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

    //  Begin Daily Log-Patient report functions
    /**
     * Display a view of the daily patient records.
     *
     */
    public function log()
    {
        $start = Carbon::parse(Input::get('from'));
        $end = Carbon::parse(Input::get('to'));
        $date = Carbon::today();
        $today = clone $date;
        $completePending = Input::get('completePending');
        $error = '';
        $from = Carbon::parse($start->toDateString());
        $to = Carbon::parse($end->toDateString());
        $accredited = array();
        //  Check radiobutton for pending/all tests is checked and assign the 'true' value
        if (Input::get('tests') === '1') {
            $pending='true';
        }
        if(!$to){
            $to=$date;
        }
        $added = clone $to;
        $toPlusOne = $added->addDay();
        $records = Input::get('records');
        if(!$records)
            $records = trans('menu.test-records');
        $testCategory = Input::get('test_category_id');
        $testType = Input::get('test_type_id');
        $labSections = TestCategory::lists('name', 'id');
        if($testCategory)
            $testTypes = TestCategory::find($testCategory)->testTypes->lists('name', 'id');
        else
            $testTypes = array(""=>"");
        if($records==trans('menu.patient-records'))
        {
            if($from||$to)
            {
                if($from->gt($to) || $from->gt($date) || $to->gt($date))
                {
                    $error = trans('general-terms.check-date-range');
                }
                else{
                    $visits = Visit::whereBetween('created_at', [$from->toDateString(), $toPlusOne->toDateString()]);
                }
                if (count($visits) == 0) {
                    Session::flash('message', trans('messages.no-match'));
                }
            }
            else
            {

                $visits = Visit::where('created_at', 'LIKE', $date.'%')->orderBy('patient_id');
            }
            $visits = $visits->get();
            if(Input::has('word'))
            {
                $date = date("Ymdhi");
                $fileName = "daily_visits_log_".$date.".doc";
                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=".$fileName
                );
                $content = view('reports.daily.exportPatientLog', compact('visits', 'accredited'))->withInput(Input::all());
                return Response::make($content,200, $headers);
            }
            else
            {
                $to = $to->toDateString();
                $from = $from->toDateString();
                return view('report.daily.log.patient', compact('visits', 'error', 'accredited', 'from', 'to', 'records', 'completePending', 'labSections'))->withInput(Input::all());
            }
        }
        //Begin specimen rejections
        else if($records==trans('menu.specimen-rej-rec'))
        {
            $specimens = Specimen::where('specimen_status_id', '=', Specimen::REJECTED);
            /*Filter by test category*/
            if($testCategory || $testType)
            {
                $ids = TestCategory::find($testCategory)->testTypes->lists('id');
                if($testType)
                {
                    $specimens = $specimens->whereIn('specimen_type_id', DB::table('testtype_specimentypes')->where('test_type_id', $testType)->lists('specimen_type_id'));
                }
                else
                {
                    $specimens = $specimens->whereIn('specimen_type_id', DB::table('testtype_specimentypes')->whereIn('test_type_id', $ids)->lists('specimen_type_id'));
                }
            }
            /*Filter by date*/
            if($from||$to)
            {
                if($from->gt($to) || $from->gt($date) || $to->gt($date))
                {
                    $error = trans('general-terms.check-date-range');
                }
                else
                {
                    $specimens = $specimens->whereBetween('time_rejected', [$from->toDateString(), $toPlusOne->toDateString()]);
                }
            }
            else
            {
                $specimens = $specimens->where('time_rejected', 'LIKE', $date.'%')->orderBy('id');
            }
            $specimens = $specimens->get();
            if(Input::has('word')){
                $date = date("Ymdhi");
                $fileName = "daily_rejected_specimen_".$date.".doc";
                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=".$fileName
                );
                $content = view('reports.daily.exportSpecimenLog', compact('specimens', 'testCategory', 'testType', 'accredited', 'from', 'to', 'completePending', 'labSections'))->withInput(Input::all());
                return Response::make($content,200, $headers);
            }
            else
            {
                $to = $to->toDateString();
                $from = $from->toDateString();
                return view('report.daily.log.specimen', compact('labSections', 'testType', 'specimens', 'testCategory', 'error', 'accredited', 'from', 'to', 'records', 'completePending'))->withInput(Input::all());
            }
        }
        //Begin test records
        else
        {
            $tests = Test::whereNotIn('test_status_id', [Test::NOT_RECEIVED]);
            
            /*Filter by test category*/
            if($testCategory || $testType)
            {
                $ids = TestCategory::find($testCategory)->testTypes->lists('id');
                if($testType)
                {
                    $tests = $tests->whereIn('test_type_id', $ids);
                }
                else
                {
                    $tests = $tests->where('test_type_id', '=', $testType);
                }
            }
            /*Filter by all tests*/
            if($completePending==trans('menu.complete'))
            {
                $tests = $tests->whereIn('test_status_id', [Test::COMPLETED, Test::VERIFIED]);
            }
            /*Get collection of tests*/
            /*Filter by date*/
            if($from || $to)
            {
                if($from->gt($to) || $from->gt($date) || $to->gt($date))
                {
                    $error = trans('general-terms.check-date-range');
                }
                else
                {
                    $tests = $tests->whereBetween('time_created', [$from->toDateString(), $toPlusOne->toDateString()]);
                }
            }
            else
            {
                $tests = $tests->where('time_created', 'LIKE', $date->toDateString().'%');
            }

            $tests = $tests->get();
            if(Input::has('word')){
                $date = date("Ymdhi");
                $fileName = "daily_test_records_".$date.".doc";
                $headers = array(
                    "Content-type"=>"text/html",
                    "Content-Disposition"=>"attachment;Filename=".$fileName
                );
                $content = view('reports.daily.exportTestLog', compact('tests', 'testCategory', 'testType', 'completePending', 'accredited'))->withInput(Input::all());
                return Response::make($content,200, $headers);
            }
            else
            {
                $to = $to->toDateString();
                $from = $from->toDateString();
                return view('report.daily.log.test', compact('labSections', 'testTypes', 'tests', 'counts', 'testCategory', 'testType', 'completePending', 'accredited', 'error', 'from', 'to', 'records'))->withInput(Input::all());
            }
        }
    }

    /**
    *   Function to return test types of a particular test category to fill test types dropdown
    */
    public function dropdown()
    {
        $input = Input::get('test_category_id');
        $testCategory = TestCategory::find($input);
        return json_encode($testCategory->testTypes);
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
