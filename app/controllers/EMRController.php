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
    ];

    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
        \Log::info(response()->json($validator->errors()));
    } else {
      try {
        $user = API::user();
        $contained =Input::get('contained');
        $identifier = $contained[0]['identifier'][0]["value"];
        $patient = Patient::where('patient_number',$identifier);

        // male | female | other | unknown
        $gender = ['male' => Gender::male, 'female' => Gender::female];
        // if patient exists
        if ($patient->count()) {
            $patient = $patient->first();
        }else{

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
        foreach (Input::get('code')['coding'] as $coding) {
          // save order items in tests
          $test = new Test;
          $test->visit_id = $visit->id;
          $test->test_type_id = EmrTestTypeAlias::where('emr_alias',$coding['code'])->first()->test_type_id;
          $test->test_status_id = TestStatus::pending;
          $test->created_by = $userList->id;
          $test->requested_by = Input::get('contained')[1]['name'][0]['given'][0]." ".Input::get('contained')[1]['name'][0]['family'];// practitioner

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

        ThirdPartyAccess::where('email', 'ml4afrika@play.dev')->update(['access_token' => $accessToken]);

        return;
      }
  }

  public static  function sendTestResults($testID)
    {
        $diagnosticOrder = DiagnosticOrder::where('test_id',$testID);

        // if order is from emr
        if ($diagnosticOrder->count()) {
            $diagnosticOrder->first();
            $test = Test::find($testID)->load('testResults');

            $thirdPartyAccess = ThirdPartyAccess::where('email', 'ml4afrika@play.dev');
            if ($thirdPartyAccess->count()) {
              $accessToken = $thirdPartyAccess->first()->access_token;
            }else{
              $accessToken = '';
            }
        }else{
            return;
        }

            $contained = [];
            $resultRreference = [];
            foreach ($test->testResults as $result) {
                $resultRreference[] = ["reference" => "#observation".$result->id];
                if ($result->measure->measure_type_id == MeasureType::numeric) {
                    $contained[] = [
                      "resourceType"=> "Observation",
                      "id"=> "observation".$result->id,//todo: check for identification of tests if such a thing exists
                      "extension"=> [
                        [
                          "url"=> "http=>//www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode",
                          "valueCode"=> $test->testType->id,
                        ]
                      ],
                      "code"=> [
                        "coding"=> [
                          [
                            "system"=> "http=>//loinc.org",
                            "code"=> "",//todo: update loinc code
                            "display"=> ""//todo: update loinc display
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
                        "value"=> "7",
                        "unit"=> $result->measure->unit,
                        "system"=> "",//todo: populate this resource accordingly
                        "code"=> $result->measure->unit
                      ]
                    ];
                }else if ($result->measure->measure_type_id == MeasureType::alphanumeric) {
                    $contained[] = [
                      "resourceType"=> "Observation",
                      "id"=> $result->id,//todo: check for identification of tests if such a thing exists
                      "extension"=> [
                        [
                          "url"=> "http=>//www.mhealth4afrika.eu/fhir/StructureDefinition/dataElementCode",
                          "valueCode"=> $test->testType->alias,
                        ]
                      ],
                      "code"=> [
                        "coding"=> [
                          [
                            "system"=> "http=>//loinc.org",
                            "code"=> "",//todo: update loinc code
                            "display"=> ""//todo: update loinc display
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
                        "value"=> $result->result,
                        "unit"=> $result->measure->unit,
                        "system"=> "",//todo: populate this resource accordingly
                        "code"=> $result->measure->unit
                      ]
                    ];
                    $contained[] = [
                        'code' => $result->measure->name,
                        'valueString' => $result->result,
                    ];
                }else if ($result->measure->measure_type_id == MeasureType::multi_alphanumeric) {
                    // adjust to capture multiple, will need some looping of measure ranges
                    $contained[] = [
                        'code' => $result->measure->name,
                        'valueString' => $result->result,
                    ];
                }else if ($result->measure->measure_type_id == MeasureType::free_text) {
                    $contained[] = [
                        'code' => $result->measure->name,
                        'valueString' => $result->result,
                    ];
                }
                }

          $results = [
              "resourceType"=> "DiagnosticReport",
              "contained"=> $contained,//the individual measures
              "extension"=> [
                [
                  "url"=> "http=>//www.mhealth4afrika.eu/fhir/StructureDefinition/eventId",
                  "valueString"=> $test->visit->patient->patient_number
                ]
              ],
              "identifier"=> [
                [
                  "value"=> $test->id
                ]
              ],
              "subject"=> [
                "reference"=>  $test->visit->patient->patient_number
              ],
              "performer"=> [
                [
                  "actor"=> [
                    "reference"=> $test->testedBy->name
                  ]
                ]
              ],
              "result"=> $resultRreference
            ];


        $client = new \GuzzleHttp\Client();

        // use verb to decide
        try {
            // send results for individual tests
            $response = $client->post('http://10.9.41.73/api/ml4afrikaresult', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-type' => 'application/json',
                    'Authorization' => 'Bearer '.$accessToken
                ],
                'json' => $results
            ]);
        }
        catch (\GuzzleHttp\Exception\ClientException $e) {
            $accessToken;
        }

        if ($response->getStatusCode() == 200) {
            $diagnosticOrder->update(['diagnostic_order_status_id' => DiagnosticOrderStatus::result_sent]);
        }
    }

}


?>