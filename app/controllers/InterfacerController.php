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
    * @param test results to be saved 
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
        $testId = Input::get('testId');
        $test = Test::find($testId);
        $testResults = Input::get('results');

        foreach ($test->testType->measures as $measure) {
            $testResult = TestResult::firstOrCreate(array('test_id' => $testID, 'measure_id' => $measure->id));
            //Validate results
            $testResult->result = $testResults[$measure->id];
            $testResult->save();
        }
    }

    /**
    * Get test, specimen, measure info related to a test
    * @param key For authentication
    * @param Filters to get specific info
    * @return json of the test info
    */
    public function getSpecimenInfo()
    {
        //Auth
        $authKey = Input::get('key');
        if(!$this->authenticate($authKey)){
            return json_encode(array('error' => 'Authentication failed'));
        }
        //Validate params
        $specimenFilter =  Input::get('specimenFilter');
        $testFilter = Input::get('testFilter');
        //return test info
        return Specimen::where('id', $specimenFilter)->with('test.testType.measures')->first();
    }

    /**
    * Get measure info related to a test
    * @param key For authentication
    * @param testId testID to get the measure info for
    * @return json of the test info
    */
    public function getTestMeasureInfo($key, $testId)
    {
        //Auth
        $authKey = $key;
        if(!$this->authenticate($authKey)){
            return json_encode(array('error' => 'Authentication failed'));
        }
        //Validate params
        $testId = $testId;
        //return test info
        $measures = DB::select('select id, name from measures where id in (select measure_id from testtype_measures where test_type_id = ?', $testId);
        return json_encode($measures);
    }
}