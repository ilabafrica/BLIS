<?php

class EMRController extends \BaseController{

  // return test menu
  public function testMenu(){
    $user = API::user();
    $testTypes = TestTypeCategory::with('testTypes')->get();
    return response()->json($testTypes);
  }

  public function store(){

    $validation = Validator::make(Input::all(), [
      'title' => 'required'
    ] );

    if($validation->fails()){
      return API::response()->array(['status' => 'failed', 'message' => $validation])->statusCode(200);
    }

    $user = API::user();

    $userList = TodoList::find($user->lists()->first()->id);

    try{

      $todo = new Todo([
        'title'    => Input::get('title'),
      ]);

      $todo->save();

      if($todo && $userList){
        $userList->todos()->save($todo);
      }

      return API::response()->array(['status' => 'success', 'message' => 'Todo was added!']);

    } catch(\Exception $e){

        return API::response()->array(['status' => 'failed', 'message' => 'There was an error. Please try again.' ])->statusCode(401);

    }

  }

  // receive and add test request on queue
  public function receiveTestRequest()
  {      
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
          \Log::info("Hety");
          try {
              if (API::user()->emr->data_standard == 'sanitas') {
                  $gender = ['Male' => Gender::male, 'Female' => Gender::female];
                  $name = new Name;
                  $name->text = $request->input('patient.fullName');
                  $name->save();
                  //Check if patient exists, if true dont save again
                  $patient = Patient::firstOrNew([
                      'identifier' => $request->input('patient.id'),
                  ]);
                  $patient->identifier = $request->input('patient.id');
                  $patient->name_id = $name->id;
                  $patient->gender_id = $gender[$request->input('patient.gender')];
                  $patient->birth_date = $request->input('patient.dateOfBirth');
                  $patient->address = $request->input('address.address');
                  // $patient->phone_number = $request->input('address.phoneNumber');
                  $patient->created_by = Auth::guard('tpa_api')->user()->id;
                  $patient->save();
                  try
                  {
                      $testName = trim($request->input('investigation'));
                      $testTypeId = TestType::where('name', 'like', $testName)->orderBy('name')->firstOrFail()->id;
                  } catch (ModelNotFoundException $e) {
                      Log::error("The test type ` $testName ` does not exist:  ". $e->getMessage());
                      // todo: send appropriate error message
                      return null;
                  }
                  $visitType = ['ip' => EncounterClass::inpatient, 'op' => EncounterClass::outpatient];
                  //Check if visit exists, if true dont save again
                  $encounter = Encounter::firstOrNew([
                      'identifier' => $request->input('patientVisitNumber'),
                      'encounter_class_id' => $visitType[$request->input('orderStage')],
                      'patient_id' => $patient->id,
                  ]);
                      $test = Test::firstOrNew([
                          'identifier' => $request->input('labNo'),
                      ]);
                      $test->test_type_id = $testTypeId;
                      $test->test_status_id = TestStatus::pending;
                      $test->created_by = Auth::guard('tpa_api')->user()->id;
                      $test->requested_by = $request->input('requestingClinician');
                      \DB::transaction(function() use ($encounter, $test) {
                          $encounter->save();
                          $test->visit_id = $encounter->id;
                          $test->save();
                      });
              }else if (Auth::guard('tpa_api')->user()->emr->data_standard == 'fhir') {
                  $contained =$request->input('contained');
                  $patient = Patient::where('identifier',$contained[0]['identifier']);
                  // male | female | other | unknown
                  $gender = ['male' => Gender::male, 'female' => Gender::female]; 
                  // if patient exists
                  if ($patient->count()) {
                      $patient = $patient->first();
                  }else{
                      \Log::info( $contained);
                      // create patient entry
                      $name = new Name;
                      $name->family = $contained[0]['name'][0]['family'];
                      $name->given = $contained[0]['name'][0]['given'][0];
                      $name->text =$name->given." ".$name->family;
                      $name->save();
                      \Log::info($name);
                      // save subject in patient
                      $patient = new Patient;
                      $patient->identifier = $contained[0]['identifier'][0]['value'];
                      $patient->name_id = $name->id;
                      $patient->gender_id = $gender[$contained[0]['gender']];
                      $patient->birth_date = $contained[0]['birthDate'];
                      $patient->created_by = Auth::guard('tpa_api')->user()->id;
                      $patient->save();
                  }
                  $encounterClass = ['inpatient' => EncounterClass::inpatient, 'outpatient' => EncounterClass::outpatient];
                  // on the lab side, assuming each set of requests represent an encounter
                  $requester =$request->input('requester');
                  $encounter = new Encounter;
                  $encounter->identifier =$contained[0]['identifier'][0]['value'];
                  $encounter->patient_id = $patient->id;
                  $encounter->location_id = $request->input('location_id');
                  $encounter->practitioner_name = $requester['agent']['name'];
                  $encounter->practitioner_contact = $requester['agent']['contact'];
              
                  $encounter->practitioner_organisation = $requester['agent']['organization'];
                  $encounter->save();
                  // recode each item in DiagnosticOrder to keep track of what has happened to it
                  foreach ($request->input('item') as $item) {
                      // save order items in tests
                      $test = new Test;
                      $test->encounter_id = $encounter->id;
                      $test->identifier = $contained[0]['identifier'][0]['value'];// using patient for now
                      if (\ILabAfrica\EMRInterface\EMR::where('third_party_app_id', Auth::guard('tpa_api')->user()->id)->first()->knows_test_menu) {
                          $test->test_type_id = $item['test_type_id'];
                      }else{
                          $test->test_type_id = EmrTestTypeAlias::where('emr_alias',$item['test_type_id'])->first()->test_type_id;
                      }
                      $test->test_status_id = TestStatus::pending;
                      $test->created_by = Auth::guard('tpa_api')->user()->id;
                      $test->requested_by = $requester['agent']['name'];// practitioner
                      $test->save();
                      $diagnosticOrder = new DiagnosticOrder;
                      $diagnosticOrder->test_id = $test->id;
                      $diagnosticOrder->save();
                  }
              }
              else{
                  $patient = Patient::where('identifier',$request->input('subject.identifier'));
                  // male | female | other | unknown
                  $gender = ['male' => Gender::male, 'female' => Gender::female]; 
                  // if patient exists
                  if ($patient->count()) {
                      $patient = $patient->first();
                  }else{
                      // create patient entry
                      $name = new Name;
                      $name->text = $request->input('subject.name');
                      $name->save();
                      // save subject in patient
                      $patient = new Patient;
                      $patient->identifier = $request->input('subject.identifier');
                      $patient->name_id = $name->id;
                      $patient->gender_id = $gender[$request->input('subject.gender')];
                      $patient->birth_date = $request->input('subject.birthDate');
                      $patient->created_by = Auth::guard('tpa_api')->user()->id;
                      $patient->save();
                  }
                  $encounterClass = ['inpatient' => EncounterClass::inpatient, 'outpatient' => EncounterClass::outpatient];
                  // on the lab side, assuming each set of requests represent an encounter
                  $encounter = new Encounter;
                  $encounter->identifier = $request->input('subject.identifier');
                  $encounter->patient_id = $patient->id;
                  $encounter->location_id = $request->input('location_id');
                  $encounter->practitioner_name = $request->input('orderer.name');
                  $encounter->practitioner_contact = $request->input('orderer.contact');
                  $encounter->encounter_class_id = $encounterClass[$request->input('encounter.class')];
                  $encounter->practitioner_organisation = $request->input('orderer.organisation');
                  $encounter->save();
                  // recode each item in DiagnosticOrder to keep track of what has happened to it
                  foreach ($request->input('item') as $item) {
                      // save order items in tests
                      $test = new Test;
                      $test->encounter_id = $encounter->id;
                      $test->identifier = $request->input('subject.identifier');// using patient for now
                      if (\ILabAfrica\EMRInterface\EMR::where('third_party_app_id', Auth::guard('tpa_api')->user()->id)->first()->knows_test_menu) {
                          $test->test_type_id = $item['test_type_id'];
                      }else{
                          $test->test_type_id = EmrTestTypeAlias::where('emr_alias',$item['test_type_id'])->first()->test_type_id;
                      }
                      $test->test_status_id = TestStatus::pending;
                      $test->created_by = Auth::guard('tpa_api')->user()->id;
                      $test->requested_by = $request->input('orderer.name');// practitioner
                      $test->save();
                      $diagnosticOrder = new DiagnosticOrder;
                      $diagnosticOrder->test_id = $test->id;
                      $diagnosticOrder->save();
                  }
              }
              return response()->json(['message' => 'Test Request Received']);
          } catch (\Illuminate\Database\QueryException $e) {
              return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
          }
      }
  }

  public function destroy($id){

    $user = API::user();
    $userList = TodoList::find($user->lists()->first()->id);

    $todo = Todo::find($id);

    if($todo && $todo->list_id == $userList->id){

      $todo->delete();

      return API::response()->array(['status' => 'success', 'message' => "Todo was deleted." ])->statusCode(200);

    }

    return API::response()->array(['status' => 'failed', 'message' => 'There was an error. Please try again.' ])->statusCode(401);

  }

}

?>         