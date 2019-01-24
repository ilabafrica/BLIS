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

  public static function getToken($testID)
  {
      $clientLogin = new \GuzzleHttp\Client();
      // send results for individual tests for starters
      $loginResponse = $clientLogin->post('http://10.9.41.73/api/tpa/login', [
          'headers' => [
              'Accept' => 'application/json',
              'Content-type' => 'application/json'
          ],
          'json' => [
              'email' => 'ml4afrika@play.dev',
              'password' => 'password'
           ],
      ]);

     if ($loginResponse->getStatusCode() == 200) {
          \Log::info('login success');
          $accessToken = json_decode($loginResponse->getBody()->getContents())->access_token;
          dd($accessToken);
          \App\Models\ThirdPartyAccess::where('email', 'ml4afrika@play.dev')->update(['access_token' => $accessToken]);

          $this->sendTestResults($testID);
      }
  }

  public function sendTestResults($testID)
    {
        $diagnosticOrder = DiagnosticOrder::where('test_id',$testID);

        // if order is from emr
        if ($diagnosticOrder->count()) {
            $diagnosticOrder->first();
            $test = Test::find($testID)->load('results');
            \Log::info($test->thirdPartyCreator->access);

            $thirdPartyAccess = \App\Models\ThirdPartyAccess::where('email',$test->thirdPartyCreator->access->email);
            if ($thirdPartyAccess->count()) {
                $accessToken = $thirdPartyAccess->first()->access_token;
            }else{
                $accessToken = '';
            }
        }else{
            return;
        }

        if ($test->thirdPartyCreator->emr->data_standard == 'sanitas') {

            $result = '';
            $jsonResultString = sprintf('{"labNo": "%s","requestingClinician": "%s", "result": "%s", "verifiedby": "%s", "techniciancomment": "%s"}', 
                                $test->identifier, $test->tested_by, $result, $test->verified_by, $test->comment);
            $results = "labResult=".urlencode($jsonResultString);

        }elseif($test->thirdPartyCreator->emr->data_standard == 'fhir'){
            $measures = [];
            foreach ($test->results as $result) {
                if ($result->measure->measure_type_id == MeasureType::numeric) {
                    $measures[] = [
                        'code' => $result->measure->name,
                        'valueString' => $result->result,
                    ];
                }else if ($result->measure->measure_type_id == MeasureType::alphanumeric) {
                    $measures[] = [
                        'code' => $result->measure->name,
                        'valueString' => $result->measureRange->display,
                    ];
                }else if ($result->measure->measure_type_id == MeasureType::multi_alphanumeric) {
                    // adjust to capture multiple, will need some looping of measure ranges
                    $measures[] = [
                        'code' => $result->measure->name,
                        'valueString' => $result->measureRange->display,
                    ];
                }else if ($result->measure->measure_type_id == MeasureType::free_text) {
                    $measures[] = [
                        'code' => $result->measure->name,
                        'valueString' => $result->result,
                    ];
                }
            }
            $results = [
              "resourceType"=> "DiagnosticReport",
              "contained"=> [
                [
                  "resourceType"=> "Observation",
                  "id"=> $test->encounter->patient->identifier,
                  "extension"=> [
                    [
                      "url"=> "http=>//www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode",
                      "valueCode"=> "hbCodeExample"
                    ]
                ],
                "code"=> [
                  "coding"=> [
                    [
                      "system"=> "http=>//loinc.org",
                      "code"=> "718-7",
                      "display"=> "Hemoglobin [Mass/volume] in Blood"
                    ]
                  ]
                ],
                "effectiveDateTime"=> $test->time_completed,
                "performer"=> [
                  [
                    "reference"=> $test->testedBy->name,
                  ]
                ],
                  "valueQuantity"=> [
                    "value"=> $measures,
                    "unit"=> "g/dl",
                    "system"=> "http=>//unitsofmeasure.org",
                    "code"=> "g/dL"
                  ]
               ],
               [

                  "resourceType"=> "Observation",
                  "id"=> $test->encounter->patient->identifier,
                  "extension"=> [
                    [
                      "url"=> "http=>//www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode",
                      "valueCode"=> "rhCodeExample"
                    ]
                  ],
                  "code"=> [
                    "coding"=> [
                      [
                        "system"=> "http=>//loinc.org",
                        "code"=> "883-9",
                        "display"=> "ABO group [Type] in Blood"
                      ]
                    ]
                  ],
                  "effectiveDateTime"=> $test->time_completed,
                  "performer"=> [
                    [
                      "reference"=> $test->testedBy->name
                    ]
                  ],
                  "valueCodeableConcept"=> [
                  "coding"=> [
                    [
                      "system"=> "http=>//snomed.info/sct",
                      "code"=> "112144000",
                      "display"=> "Blood group A (finding)"
                    ]
                  ],
                  "text"=> "A"
                  ]
                ]
              ],
              "extension"=> [
                [
                  "url"=> "http=>//www.mhealth4afrika.eu/fhir/StructureDefinition/eventId",
                  "valueString"=> "exampleEventId"
                ]
              ],
              "identifier"=> [
                [
                  "value"=> $test->id
                ]
              ],
              "subject"=> [
                  "reference"=>  $test->encounter->patient->identifier
              ],
              "performer"=> [
                [
                  "actor"=> [
                    "reference"=> $test->testedBy->name
                  ]
                ]
              ],
              "result"=> [
                [
                  "reference"=> "#Observation1"
                ],
                [
                  "reference"=> "#Observation2"
                ]
              ]
            ];
        }

        $client = new Client();

        // use verb to decide
        if ($test->thirdPartyCreator->emr->data_standard == 'sanitas') {
            $response = $client->request('GET', $test->thirdPartyCreator->emr->result_url.'?'.$results, ['debug' => true]);
        }else{
            try {
                // send results for individual tests
                $response = $client->request('POST', $test->thirdPartyCreator->emr->result_url, [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/json',
                        'Authorization' => 'Bearer '.$accessToken
                    ],
                    'json' => $results
                ]);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $this->getToken($test->id, $test->thirdPartyCreator->access->email);
            }
        }
        if ($response->getStatusCode() == 200) {
            $diagnosticOrder->update(['diagnostic_order_status_id' => DiagnosticOrderStatus::result_sent]);
        }
    }

}


?>         