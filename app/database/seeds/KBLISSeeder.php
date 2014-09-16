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
        $specimen_types = SpecimenType::create(array("name" => "Whole Blood"));
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

        /* Patients table */
        $patients = Patient::create(
            array(
                "name" => "Jam Felix", "email" => "fjamkizi@x.com", "patient_number" => "1002", "dob" => "2000-01-01",
                "name" => "Emma Wallace", "email" => "emma@snd.com", "patient_number" => "1003", "dob" => "1990-03-01",
                "name" => "Jack Tee", "email" => "info@jt.co.ke", "patient_number" => "1004", "dob" => "1999-12-18",
                "name" => "Hu Jintao", "email" => "hu@.un.org", "patient_number" => "1005", "dob" => "1956-10-28",
                "name" => "Lance Opiyo", "email" => "lance@x.com", "patient_number" => "2150", "dob" => "2012-01-01",
            )
        );
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
          array("id" => "1","name" => "Pending","test_phase_id" => "1"),//Pre-Analytical
          array("id" => "2","name" => "Started","test_phase_id" => "2"),//Analytical
          array("id" => "3","name" => "Completed","test_phase_id" => "3"),//Post-Analytical
          array("id" => "4","name" => "Verified","test_phase_id" => "3")//Post-Analytical
        );
        foreach ($test_statuses as $test_status)
        {
            TestStatus::create($test_status);
        }
        $this->command->info('test_statuses seeded');

        /* Specimen Status table */
        $specimen_statuses = array(
          array("id" => "1", "name" => "Accepted"),
          array("id" => "2", "name" => "Rejected")
        );
        foreach ($specimen_statuses as $specimen_status)
        {
            SpecimenStatus::create($specimen_status);
        }
        $this->command->info('specimen_statuses seeded');

        /* Visits table */
        $visits_accepted_pending = Visit::create(array("patient_id" => $patients->id, "created_at" => '2014-08-27 08:12:33', "updated_at" => '2014-08-27 08:12:33'));
        $visits_accepted_started = Visit::create(array("patient_id" => $patients->id , "created_at" => '2014-08-27 08:12:33', "updated_at" => '2014-08-27 08:12:33'));
        $visits_accepted_completed = Visit::create(array("patient_id" => $patients->id, "created_at" => '2014-08-27 08:12:33', "updated_at" => '2014-08-27 08:12:33'));
        $visits_accepted_verified = Visit::create(array("patient_id" => $patients->id, "created_at" => '2014-08-27 08:12:33', "updated_at" => '2014-08-27 08:12:33'));
        $visits_rejected_pending = Visit::create(array("patient_id" => $patients->id, "created_at" => '2014-08-27 08:12:33', "updated_at" => '2014-08-27 08:12:33'));
        $visits_rejected_started = Visit::create(array("patient_id" => $patients->id, "created_at" => '2014-08-27 08:12:33', "updated_at" => '2014-08-27 08:12:33'));
        $visits_rejected_completed = Visit::create(array("patient_id" => $patients->id, "created_at" => '2014-08-27 08:12:33', "updated_at" => '2014-08-27 08:12:33'));
        $this->command->info('visits seeded');

        /* Rejection Reasons table */
        $rejection_reasons_pre_analytic = RejectionReason::create(array("reason" => "Looked kinda funny!"));
        $rejection_reasons_analytic = RejectionReason::create(array("reason" => "Looked funny actually!"));
        $rejection_reasons_post_analytic = RejectionReason::create(array("reason" => "Looked like super funny!"));
        $this->command->info('rejection_reasons seeded');

        /* Specimen table */
        $specimens_accepted_pre_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_types->id,
                "specimen_status_id" => "1",//accepted
                "test_phase_id" => "1",//Pre-Analytical for test_status:pending
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        
        $specimens_accepted_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_types->id,
                "specimen_status_id" => "1",//accepted
                "test_phase_id" => "2",//Analytical for test_status:started
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        
        $specimens_accepted_post_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_types->id,
                "specimen_status_id" => "1",//accepted
                "test_phase_id" => "3",//Post-Analytical for test_status:completed
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        
        $specimens_accepted_post_analytic_verified = Specimen::create(
            array(
                "specimen_type_id" => $specimen_types->id,
                "specimen_status_id" => "1",//accepted
                "test_phase_id" => "3",//Post-Analytical for test_status:verified
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );        
        
        $specimens_rejected_pre_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_types->id,
                "specimen_status_id" => "2",//rejected
                "rejection_reason_id" => $rejection_reasons_pre_analytic->id,
                "test_phase_id" => "1",//Pre-Analytical
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );

        $specimens_rejected_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_types->id,
                "specimen_status_id" => "2",//rejected
                "rejection_reason_id" => $rejection_reasons_analytic->id,
                "test_phase_id" => "2",//Analytical
                "created_by" => "1",
                "referred_from" => "0",
                "referred_to" => "0",
                "time_accepted" => "0000-00-00 00:00:00",
            )
        );

        $specimens_rejected_post_analytic = Specimen::create(
            array(
                "specimen_type_id" => $specimen_types->id,
                "specimen_status_id" => "2",//rejected
                "rejection_reason_id" => $rejection_reasons_post_analytic->id,
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
                "visit_id" => $visits_accepted_pending->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_pre_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => "1",//Pending
                "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_created" => "0000-00-00 00:00:00",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_accepted_pending = Test::create(
            array(
                "visit_id" => $visits_accepted_pending->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_pre_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => "1",//Pending
                "created_by" => "1",
            )
        );        
        
        $test_gxm_accepted_completed = Test::create(
            array(
                "visit_id" => $visits_accepted_pending->id,
                "test_type_id" => $test_type_gxm->id,
                "specimen_id" => $specimens_accepted_post_analytic_verified->id,
                "interpretation" => "COMPATIBLE WITH 061832914 B/G A POS.EXPIRY19/8/14",
                "test_status_id" => "3",//Completed
                "created_by" => "1",
                "tested_by" => "1",
                "verified_by" => "1",
                "requested_by" => "1",
            )
        );        
        
        $test_hb_accepted_completed = Test::create(
            array(
                "visit_id" => $visits_accepted_pending->id,
                "test_type_id" => $test_type_hb->id,
                "specimen_id" => $specimens_accepted_post_analytic_verified->id,
                "interpretation" => "??",
                "test_status_id" => "3",//Completed
                "created_by" => "2",
                "tested_by" => "2",
                "verified_by" => "1",
                "requested_by" => "3",
            )
        );        
        
        $tests_accepted_started = Test::create(
            array(
                "visit_id" => $visits_accepted_started->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => "2",//Started
                "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_created" => "0000-00-00 00:00:00",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_accepted_completed = Test::create(
            array(
                "visit_id" => $visits_accepted_completed->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_post_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => "3",//Completed
                "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_created" => "0000-00-00 00:00:00",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_accepted_verified = Test::create(
            array(
                "visit_id" => $visits_accepted_verified->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_accepted_post_analytic_verified->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => "4",//Verified
                 "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_created" => "0000-00-00 00:00:00",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_rejected_pending = Test::create(
            array(
                "visit_id" => $visits_rejected_pending->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_rejected_pre_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => "1",//Pending
                 "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_created" => "0000-00-00 00:00:00",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_rejected_started = Test::create(
            array(
                "visit_id" => $visits_rejected_started->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_rejected_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => "2",//Started
                 "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_created" => "0000-00-00 00:00:00",
                "time_started" => "0000-00-00 00:00:00",
            )
        );        
        
        $tests_rejected_completed = Test::create(
            array(
                "visit_id" => $visits_rejected_completed->id,
                "test_type_id" => $test_types->id,//BS for MPS
                "specimen_id" => $specimens_rejected_post_analytic->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => "3",//Completed
                 "created_by" => "1",
                "tested_by" => "0",
                "verified_by" => "0",
                "requested_by" => "0",
                "time_created" => "0000-00-00 00:00:00",
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
        
        /* Permissions table */
        $permissions = array(
            array("name" => "view_names", "display_name" => "Can view patient names"),
            array("name" => "verify_tests", "display_name" => "Can verify tests"),
            array("name" => "add_patients", "display_name" => "Can add patients"),
            array("name" => "configure_tests", "display_name" => "Can configure tests"),
            array("name" => "enter_tests", "display_name" => "Can enter tests")
        );
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        $this->command->info('Permissions table seeded');

        /* Roles table */
        $roles = array(
            array("name" => "Manager"), 
            array("name" => "Cashier")
        );
        foreach ($roles as $role) {
            Role::create($role);
        }
        $this->command->info('Roles table seeded');
    }
}
