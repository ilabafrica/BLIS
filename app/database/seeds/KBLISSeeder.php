<?php

class KBLISSeeder
extends DatabaseSeeder
{
    public function run()
    {
        /* Users table */
        $users = array(
            array(
                "username" => "administrator", "password" => Hash::make("password"), "email" => "admin@kblis.org",
                "name" => "kBLIS Administrator", "designation" => "Programmer"
            ),
            array(
                "username" => "lmorena", "password" => Hash::make("password"), "email" => "lmorena@kblis.org",
                "name" => "L. Morena", "designation" => "Lab Technologist"
            ),
            array(
                "username" => "abumeyang", "password" => Hash::make("password"), "email" => "abumeyang@kblis.org",
                "name" => "A. Abumeyang", "designation" => "Doctor"
            ),
        );

        foreach ($users as $user)
        {
            User::create($user);
        }
        $this->command->info('users seeded');
        

        /* Specimen Types table */
        $spec_types = array(
            array("name" => "Ascitic Tap"),
            array("name" => "Aspirate"),
            array("name" => "CSF"),
            array("name" => "Dried Blood Spot"),
            array("name" => "High Vaginal Swab"),
            array("name" => "Nasal Swab"),
            array("name" => "Plasma"),
            array("name" => "Plasma EDTA"),
            array("name" => "Pleural Tap"),
            array("name" => "Pus Swab"),
            array("name" => "Rectal Swab"),
            array("name" => "Semen"),
            array("name" => "Serum"),
            array("name" => "Skin"),
            array("name" => "Sputum"),
            array("name" => "Stool"),
            array("name" => "Synovial Fluid"),
            array("name" => "Throat Swab"),
            array("name" => "Urethral Smear"),
            array("name" => "Urine"),
            array("name" => "Vaginal Smear"),
            array("name" => "Water"),
            array("name" => "Whole Blood"),
        );

        foreach ($spec_types as $specimen_type)
        {
            SpecimenType::create($specimen_type);
        }
        $this->command->info('specimen_types seeded');
        
        /* Test Categories table - These map on to the lab sections */
        $test_categories = TestCategory::create(array("name" => "PARASITOLOGY","description" => ""));
        $this->command->info('test_categories seeded');
        
        
        /* Measure Types */
        $measure_types = array(
            array("id" => "1", "name" => "Numeric Range", "created_at" => "0000-00-00 00:00:00", "updated_at" => "0000-00-00 00:00:00"),
            array("id" => "2", "name" => "Alphanumeric Values", "created_at" => "0000-00-00 00:00:00", "updated_at" => "0000-00-00 00:00:00"),
            array("id" => "3", "name" => "Autocomplete", "created_at" => "0000-00-00 00:00:00", "updated_at" => "0000-00-00 00:00:00"),
            array("id" => "4", "name" => "Free Text", "created_at" => "0000-00-00 00:00:00", "updated_at" => "0000-00-00 00:00:00")
        );

        foreach ($measure_types as $measure_type)
        {
            MeasureType::create($measure_type);
        }
        $this->command->info('measure_types seeded');
                
        /* Measures table */
        $measureBSforMPS = Measure::create(array("measure_type_id" => "2", "name" => "BS for mps", "measure_range" => "No mps seen/+/++/+++/++++", "unit" => ""));
        $measures = array(
            array("measure_type_id" => "2", "name" => "Grams stain", "measure_range" => "Positive/Negative", "unit" => ""),
            array("measure_type_id" => "2", "name" => "SERUM AMYLASE", "measure_range" => "Low/Normal/High", "unit" => ""),
            array("measure_type_id" => "2", "name" => "calcium", "measure_range" => "Low/Normal/High", "unit" => ""),
            array("measure_type_id" => "1", "name" => "URIC ACID", "measure_range" => "", "unit" => "mg/dl"),
            array("measure_type_id" => "4", "name" => "CSF for biochemistry", "measure_range" => "", "unit" => ""),
            array("measure_type_id" => "4", "name" => "PSA", "measure_range" => "", "unit" => ""),
            array("measure_type_id" => "1", "name" => "Total", "measure_range" => "", "unit" => "mg/dl"),
            array("measure_type_id" => "1", "name" => "Alkaline Phosphate", "measure_range" => "", "unit" => "u/l"),
            array("measure_type_id" => "2", "name" => "SGOT", "measure_range" => "Low/Normal/High", "unit" => ""),
            array("measure_type_id" => "1", "name" => "Direct", "measure_range" => "", "unit" => "mg/dl"),
            array("measure_type_id" => "1", "name" => "Total Proteins", "measure_range" => "", "unit" => ""),
            array("measure_type_id" => "4", "name" => "LFTS", "measure_range" => "", "unit" => "NULL"),
            array("measure_type_id" => "1", "name" => "Chloride", "measure_range" => "", "unit" => "mmol/l"),
            array("measure_type_id" => "1", "name" => "Potassium", "measure_range" => "", "unit" => "mmol/l"),
            array("measure_type_id" => "1", "name" => "Sodium", "measure_range" => "", "unit" => "mmol/l"),
            array("measure_type_id" => "4", "name" => "Electrolytes", "measure_range" => "", "unit" => ""),
            array("measure_type_id" => "1", "name" => "Creatinine", "measure_range" => "", "unit" => "mg/dl"),
            array("measure_type_id" => "1", "name" => "Urea", "measure_range" => "", "unit" => "mg/dl"),
            array("measure_type_id" => "4", "name" => "RFTS", "measure_range" => "", "unit" => ""),
            array("measure_type_id" => "4", "name" => "TFT", "measure_range" => "", "unit" => ""),
            array("measure_type_id" => "2", "name" => "Indirect COOMBS test", "measure_range" => "Positive/Negative", "unit" => ""),
            array("measure_type_id" => "2", "name" => "Direct COOMBS test", "measure_range" => "Positive/Negative", "unit" => ""),
            array("measure_type_id" => "2", "name" => "Du test", "measure_range" => "Positive/Negative", "unit" => "")
        );

        foreach ($measures as $measure)
        {
            Measure::create($measure);
        }
        $measureGXM = Measure::create(array("measure_type_id" => "4", "name" => "GXM", "measure_range" => "", "unit" => ""));
        $measureBG = Measure::create(array("measure_type_id" => "2", "name" => "Blood Grouping", "measure_range" => "O-/O+/A-/A+/B-/B+/AB-/AB+", "unit" => ""));
        $measureHB = Measure::create(array("measure_type_id" => "1", "name" => "HB", "measure_range" => "", "unit" => "g/dL"));

        $this->command->info('measures seeded');
        
        /* Test Types table */
        $test_types = TestType::create(array("name" => "BS for mps", "section_id" => $test_categories->id));
        $test_type_gxm = TestType::create(array("name" => "GXM", "section_id" => $test_categories->id));
        $test_type_hb = TestType::create(array("name" => "HB", "section_id" => $test_categories->id));
        $this->command->info('test_types seeded');

        /* TestType Measure table */
        $testtype_measure = TestTypeMeasure::create(array("test_type_id" => $test_types->id, "measure_id" => $measureBSforMPS->id));
        $testtype_measure = TestTypeMeasure::create(array("test_type_id" => $test_type_gxm->id, "measure_id" => $measureGXM->id));
        $testtype_measure = TestTypeMeasure::create(array("test_type_id" => $test_type_gxm->id, "measure_id" => $measureBG->id));
        $testtype_measure = TestTypeMeasure::create(array("test_type_id" => $test_type_hb->id, "measure_id" => $measureHB->id));

        /* testtype_specimentypes table */
        DB::insert('INSERT INTO testtype_specimentypes (test_type_id, specimen_type_id) VALUES (?, ?)', array($test_types->id, 23));
        DB::insert('INSERT INTO testtype_specimentypes (test_type_id, specimen_type_id) VALUES (?, ?)', array($test_type_gxm->id, 23));
        DB::insert('INSERT INTO testtype_specimentypes (test_type_id, specimen_type_id) VALUES (?, ?)', array($test_type_hb->id, 23));

        $this->command->info('testtype_specimentypes seeded');

        /* Patients table */
        $patients_array = array(
                array("name" => "Jam Felicia", "email" => "fj@x.com", "patient_number" => "1002", "dob" => "2000-01-01", "gender" => "1"),
                array("name" => "Emma Wallace", "email" => "emma@snd.com", "patient_number" => "1003", "dob" => "1990-03-01", "gender" => "1"),
                array("name" => "Jack Tee", "email" => "info@jt.co.ke", "patient_number" => "1004", "dob" => "1999-12-18", "gender" => "0"),
                array("name" => "Hu Jintao", "email" => "hu@.un.org", "patient_number" => "1005", "dob" => "1956-10-28", "gender" => "0"),
                array("name" => "Lance Opiyo", "email" => "lance@x.com", "patient_number" => "2150", "dob" => "2012-01-01", "gender" => "0"));
        foreach ($patients_array as $pat) {
            $patients[] = Patient::create($pat);
        }

        $this->command->info('patients seeded');

        /* Test Phase table */
        $test_phases = array(
          array("id" => "1", "name" => "Pre-Analytical"),
          array("id" => "2", "name" => "Analytical"),
          array("id" => "3", "name" => "Post-Analytical")
        );
        foreach ($test_phases as $test_phase)
        {
            TestPhase::create($test_phase);
        }
        $this->command->info('test_phases seeded');

        /* Test Status table */
        $test_statuses = array(
          array("id" => "1","name" => "pending","test_phase_id" => "1"),//Pre-Analytical
          array("id" => "2","name" => "started","test_phase_id" => "2"),//Analytical
          array("id" => "3","name" => "completed","test_phase_id" => "3"),//Post-Analytical
          array("id" => "4","name" => "verified","test_phase_id" => "3")//Post-Analytical
        );
        foreach ($test_statuses as $test_status)
        {
            TestStatus::create($test_status);
        }
        $this->command->info('test_statuses seeded');

        /* Specimen Status table */
        $specimen_statuses = array(
          array("id" => "1", "name" => "Not Collected"),
          array("id" => "2", "name" => "Accepted"),
          array("id" => "3", "name" => "Rejected")
        );
        foreach ($specimen_statuses as $specimen_status)
        {
            SpecimenStatus::create($specimen_status);
        }
        $this->command->info('specimen_statuses seeded');

        /* Visits table */
        
        for ($i=0; $i < 7; $i++) { 
            $visits[] = Visit::create(array("patient_id" => $patients[rand(0,count($patients)-1)]->id));
        }
        $this->command->info('visits seeded');

        /* Rejection Reasons table */
        $rejection_reasons_array = array(
          array("reason" => "Poorly labelled"),
          array("reason" => "Over saturation"),
          array("reason" => "Insufficient Sample"),
          array("reason" => "Scattered"),
          array("reason" => "Clotted Blood"),
          array("reason" => "Two layered spots"),
          array("reason" => "Serum rings"),
          array("reason" => "Scratched"),
          array("reason" => "Haemolysis"),
          array("reason" => "Spots that cannot elute"),
          array("reason" => "Leaking"),
          array("reason" => "Broken Sample Container"),
          array("reason" => "Mismatched sample and form labelling"),
          array("reason" => "Missing Labels on container and tracking form"),
          array("reason" => "Empty Container"),
          array("reason" => "Samples without tracking forms"),
          array("reason" => "Poor transport"),
          array("reason" => "Lipaemic"),
          array("reason" => "Wrong container/Anticoagulant"),
          array("reason" => "Request form without samples"),
          array("reason" => "Missing collection date on specimen / request form."),
          array("reason" => "Name and signature of requester missing"),
          array("reason" => "Mismatched information on request form and specimen container."),
          array("reason" => "Request form contaminated with specimen"),
          array("reason" => "Duplicate specimen received"),
          array("reason" => "Delay between specimen collection and arrival in the laboratory"),
          array("reason" => "Inappropriate specimen packing"),
          array("reason" => "Inappropriate specimen for the test"),
          array("reason" => "Inappropriate test for the clinical condition"),
          array("reason" => "No Label"),
          array("reason" => "Leaking"),
          array("reason" => "No Sample in the Container"),
          array("reason" => "No Request Form"),
          array("reason" => "Missing Information Required"),
        );
        foreach ($rejection_reasons_array as $rejection_reason)
        {
            $rejection_reasons[] = RejectionReason::create($rejection_reason);
        }
        $this->command->info('rejection_reasons seeded');

        /* Specimen table */
        $specimen_type_id = SpecimenType::all()->last()->id; //Whole Blood
        $specimens_accepted_pre_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_type_id,
                "specimen_status_id" => Specimen::ACCEPTED,
                "test_phase_id" => "1",//Pre-Analytical for test_status:pending
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        
        $specimens_accepted_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_type_id,
                "specimen_status_id" => Specimen::ACCEPTED,
                "test_phase_id" => "2",//Analytical for test_status:started
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        
        $specimens_accepted_post_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_type_id,
                "specimen_status_id" => Specimen::ACCEPTED,
                "test_phase_id" => "3",//Post-Analytical for test_status:completed
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        
        $specimens_accepted_post_analytic_verified = Specimen::create(
            array(
                "specimen_type_id" => $specimen_type_id,
                "specimen_status_id" => Specimen::ACCEPTED,
                "test_phase_id" => "3",//Post-Analytical for test_status:verified
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        
        $specimens_rejected_pre_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_type_id,
                "specimen_status_id" => Specimen::REJECTED,
                "rejection_reason_id" => $rejection_reasons[rand(0,count($rejection_reasons)-1)]->id,
                "test_phase_id" => "1",//Pre-Analytical
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );

        $specimens_rejected_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_type_id,
                "specimen_status_id" => Specimen::REJECTED,
                "rejection_reason_id" => $rejection_reasons[rand(0,count($rejection_reasons)-1)]->id,
                "test_phase_id" => "2",//Analytical
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );

        $specimens_rejected_post_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_type_id,
                "specimen_status_id" => Specimen::REJECTED,
                "rejection_reason_id" => $rejection_reasons[rand(0,count($rejection_reasons)-1)]->id,
                "test_phase_id" => "3",//Post-Analytical
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        $this->command->info('specimens seeded');

        /* Test table */
        $tests_accepted_pending = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_pre_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => Test::PENDING,
                "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_accepted_pending = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_pre_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => Test::PENDING,
                "created_by" => "1",
                "requested_by" => "Dr. Abou Meyang",
            )
        );        
        
        $test_gxm_accepted_completed = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_type_gxm->id,
                "specimen_id" => $specimens_accepted_post_analytic_verified->id,
                "interpretation" => "COMPATIBLE WITH 061832914 B/G A POS.EXPIRY19/8/14",
                "test_status_id" => Test::COMPLETED,
                "created_by" => "1",
                "tested_by" => "1",
                "verified_by" => "1",
                "requested_by" => "Dr. Abou Meyang",
            )
        );        
        
        $test_hb_accepted_completed = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_type_hb->id,
                "specimen_id" => $specimens_accepted_post_analytic_verified->id,
                "interpretation" => "??",
                "test_status_id" => Test::COMPLETED,
                "created_by" => "2",
                "tested_by" => "2",
                "verified_by" => "1",
                "requested_by" => "Genghiz Khan",
            )
        );        
        
        $tests_accepted_started = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => Test::STARTED,
                "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_accepted_completed = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_post_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => Test::COMPLETED,
                "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_accepted_verified = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_post_analytic_verified->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => Test::VERIFIED,
                 "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_rejected_pending = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_rejected_pre_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => Test::PENDING,
                 "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_rejected_started = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_rejected_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => Test::STARTED,
                 "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_rejected_completed = Test::create(
            array(
                "visit_id" => $visits[rand(0,count($visits)-1)]->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_rejected_post_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => Test::COMPLETED,
                 "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        $this->command->info('tests seeded');

        /* Test Results table */
        $testResults = array(
            array(
                "test_id" => $tests_accepted_verified->id,
                "measure_id" => $measureBSforMPS->id,//BS for MPS
                "result" => "+++",
            ),
            array(
                "test_id" => $test_gxm_accepted_completed->id,
                "measure_id" => $measureGXM->id,
                "result" => "Done",
            ),
            array(
                "test_id" => $test_gxm_accepted_completed->id,
                "measure_id" => $measureBG->id,
                "result" => "A+",
            ),
            array(
                "test_id" => $test_hb_accepted_completed->id,
                "measure_id" => $measureHB->id,
                "result" => "13.7",
            ),
        );        
        foreach ($testResults as $testResult)
        {
            TestResult::create($testResult);
        }
        $this->command->info('test results seeded');
        
        /* Referrals table */
        $referrals_array = array(
                array("Bungoma District Hospital"),
                array("Bumula Sub-District Hospital"),
                array("Kenyatta National Hospital"),
                array("Moi Referral Teaching Hospital"),
                array("Webuye Sub-District Hospital"));
        foreach ($referrals_array as $ref) {
            DB::insert("INSERT INTO referrals (referring_institution) VALUES (?)", $ref);
        }

        $this->command->info('referrals seeded');
        /* Permissions table */
        $permissions = array(
            array("name" => "manage_patients", "display_name" => "Can add patients"),
            array("name" => "verify_tests", "display_name" => "Can verify tests"),
            array("name" => "edit_tests", "display_name" => "Can edit tests"),
            array("name" => "receive_requests", "display_name" => "Can receive requests"),
            array("name" => "view_names", "display_name" => "Can view patient names"),
            array("name" => "enter_tests_results", "display_name" => "Can enter tests results"),

            array("name" => "manage_users", "display_name" => "Can manage users"),
            array("name" => "manage_test_catalog", "display_name" => "Can manage test catalog"),
            array("name" => "view_reports", "display_name" => "Can view reports")
        );
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        $this->command->info('Permissions table seeded');

        /* Roles table */
        $roles = array(
            array("name" => "Superadmin"),
            array("name" => "Technologist"),
            array("name" => "Receptionist")
        );
        foreach ($roles as $role) {
            Role::create($role);
        }
        $this->command->info('Roles table seeded');

        $user1 = User::find(1);
        $role1 = Role::find(1);
        $permissions = Permission::all();

        //Assign all permissions to role administrator
        foreach ($permissions as $permission) {
            $role1->attachPermission($permission);
        }
        //Assign role Administrator to user 1 administrator
        $user1->attachRole($role1);
    }
}
