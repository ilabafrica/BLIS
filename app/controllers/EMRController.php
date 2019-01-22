<?php

class EMRController extends \BaseController{

  // return test menu
  public function testMenu(){

    $testTypes = TestTypeCategory::with('testTypes')->get();
    return response()->json($testTypes);
  }
      
 
  // receive and add test request on queue
  public function receiveTestRequest()
  {     
      $user = API::user();
      $userList = User::find($user->id);

      $rules = [
          'contained' => 'required',
          'extension' => 'required',
          'code' => 'required',
          'subject' => 'required',
          'requester' => 'required',
          'item' => 'required',
      ];
      $validator = Validator::make(Input::all(), $rules);
      //$validator = \Validator::make($request->all(), $rules);
      if ($validator->fails()) {
          \Log::info(response()->json($validator->errors()));
      } else {
          try {
                $user = API::user();
                  $contained =Input::get('contained');
                  $identifier = $contained[0]['identifier'][0]["value"];
                  // $patient = Patient::where("id");
                  $patient = Patient::where('patient_number',$identifier);

                  // male | female | other | unknown
                  $gender = ['male' => Gender::male, 'female' => Gender::female]; 
                  // if patient exists
                  if ($patient->count()) {
                      $patient = $patient->first();
                  }else{
                      // create patient entry
                    
                      //\Log::info($user);
                      // save subject in patient
                      $patient = new Patient;
                      $patient->patient_number = $contained[0]['identifier'][0]['value'];
                      $patient->name = $contained[0]['name'][0]['family']." ".$contained[0]['name'][0]['given'][0];
                      $patient->gender = $gender[$contained[0]['gender']];
                      $patient->dob = $contained[0]['birthDate'];
                      $patient->created_by = 1;
                      $patient->save();                  
                  }               
                  // on the lab side, assuming each set of requests represent an encounter
                  $requester =Input::get('requester');
                  $visit = new Visit;
                  $visit->patient_id =$patient->id;
                  $visit->visit_type = "Out-patient";
                  $visit->visit_number = 12;
                  $visit->save();
                
                  // recode each item in DiagnosticOrder to keep track of what has happened to it
                  foreach (Input::get('item') as $item) {
                      // save order items in tests

                      $test = new Test;
                      $test->visit_id = $visit->id;
                      $test->test_type_id = EmrTestTypeAlias::where('emr_alias',$item['test_type_id'])->first()->test_type_id;
                      $test->test_status_id = TestStatus::pending;
                      $test->created_by = $userList->id;
                      $test->requested_by = $requester['agent']['name'];// practitioner
                      
                      $test->specimen_id = 1;
                      $test->interpretation = 1;
                      $test->tested_by = 1;
                      $test->verified_by = 1;
                      $test->time_created = '2020-12-09 09:52:33';

                      $test->save();
                      
                      $diagnosticOrder = new DiagnosticOrder;
                      $diagnosticOrder->test_id = $test->id;
                      $diagnosticOrder->save();
                      \Log::info($test);
                  }
              
              return API::response()->array(['message' => 'Test Request Received']);
              //return Response::json(['message' => 'Test Request Received']);
          } catch (\Illuminate\Database\QueryException $e) {
            return API::response()->array(['status' => 'error', 'message' =>  $e->getMessage()])->statusCode(500);
            //return Response::json(['status' => 'error', 'message' => $e]);
          }
      }
  }

}


?>         