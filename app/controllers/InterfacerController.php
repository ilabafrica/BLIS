<?php

class InterfacerController extends \BaseController{

    public function receiveLabRequest()
    {
        //authenticate() connection

        $labRequest = Request::getContent();
        $labRequest = str_replace(['labRequest', '='], ['', ''], $labRequest);

        //Validate::ifValid()

        //Fire event with the received data
        Event::fire('api.receivedLabRequest', json_decode($labRequest));
    }


    /**
    * Authenticate API calls using Secret keys set on the UI
    * @param authkey Key to check if valid
    * @return boolean True if key is valid
    */
    public function authenticate($authKey)
    {
        if($authKey == '123456')//default key for the time being 123456
        {
            return true;
        }
        return false;
    }

    public function connect(){}
    public function disconnect(){}
    public function searchPatients(){}
    public function searchResults(){}

    /**
    * Save results of a particular test
    * @param key For authentication
    * @param testId Id of test
    * @param measureid measure of result to be saved
    * @param result result to be saved
    * @return json with success or failure
    **/
    public function saveTestResults()
    {
        //Auth
        $authKey = Input::get('key');
        if(!$this->authenticate($authKey)){
            return json_encode(array('error' => 'Authentication failed'));
        }
        //save results
        // $result = Input::get('result');
        $results = Input::get('result');
        $resultsArray = explode(", ", $results);
        foreach ($resultsArray as $key => $result) {
            $ms = explode(":", $result);
            $rs = explode("=", $ms[1]);
            $testId  = str_replace("{", "", $ms[0]);
            $measureId = $rs[0];
            $res = $rs[1];

            try {
                $testResult = TestResult::firstOrCreate(array('test_id' => $testId, 'measure_id' => $measureId));
                //Validate results
                $testResult->result = $result;
                //TODO: Try catch to handle failure
                $testResult->save();

                $test = Test::find($testId);
                $test->test_status_id = Test::COMPLETED;
            }
            catch(\QueryException $qe){
                echo "Failed";
            }
        }
        //Return success or failures
        return Response::json(array('fixed'));
    }

    /**
    * Get test, specimen, measure info related to a test
    * @param key For authentication
    * @param Filters to get specific info
    * @return json of the test info
    */
    public function getTests()
    {
        //Auth
        $authKey = Input::get('key');
        if(!$this->authenticate($authKey)){
            return Response::json(array('error' => 'Authentication failed'), '403');
        }
        //Validate params
        $testType = Input::get('testtype');
        $dateFrom = Input::get('datefrom');
        $dateTo = Input::get('dateto');

        if( empty($testType))
        {
            return Response::json(array('error' => 'No test provided'), '404');
        }
        //Search by name / Date
        $testType = TestType::where('name', $testType)->first();

        if( !empty($testType) ){
            $tests = Test::with('visit.patient', 'testType.measures')
                 ->where(function($query)
                    {
                        $query->where('test_status_id', Test::PENDING)
                              ->orWhere('test_status_id', Test::STARTED);
                    })
                ->where('test_type_id', $testType->id)
                ->where('time_created', '>', $dateFrom)
                ->where('time_created', '<', $dateTo)
                ->get();
        }
        //Search by ID
        //$tests = Specimen::where('visit_id', $testFilter);
        return Response::json($tests, '200');
    }

    /**
    * Get measure info related to a test
    * @param key For authentication
    * @param testId testID to get the measure info for
    * @return json of the test info
    */
    public function getTestInfo()
    {
        $key = Input::get('key');
        $testId = Input::get('testId');
        //Auth
        $authKey = $key;
        if(!$this->authenticate($authKey)){
            return json_encode(array('error' => 'Authentication failed'));
        }
        //return test info
        $test = Test::with('testType', 'testType.measures', 'specimen.specimenType')->where('visit_id', $testId);
        return Response::json($test);
    }
}