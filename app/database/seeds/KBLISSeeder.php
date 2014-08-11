<?php

class KBLISSeeder
extends DatabaseSeeder
{
    public function run()
    {
        /* Truncate from linking tables */
        DB::table('testtype_measures')->truncate();
        DB::table('testtype_specimentypes')->truncate();
        DB::table('measure_ranges')->truncate();

        /* Delete from tables referenced by foreign key constraints */
        DB::table('referrals')->delete();
        DB::table('test_results')->delete();
        DB::table('tests')->delete();
        DB::table('specimens')->delete();
        DB::table('rejection_reasons')->delete();
        DB::table('visits')->delete();
        DB::table('test_statuses')->delete();
        DB::table('specimen_statuses')->delete();
        DB::table('test_phases')->delete();
        DB::table('test_types')->delete();
        DB::table('measures')->delete();
        DB::table('measure_types')->delete();
        DB::table('test_categories')->delete();
        DB::table('specimen_types')->delete();
        DB::table('patients')->delete();
        DB::table('tokens')->delete();
        DB::table('users')->delete();


        /* Truncate from tables ---- */
        DB::table('users')->truncate();

        /* Users table */
        $users = array(
            array(
                "username" => "administrator",
                "password" => Hash::make("password"),
                "email"    => "admin@example.com",
                "name"     => "kBLIS Administrator",
                "designation" => "Programmer"
            )
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
            array("id" => "1", "name" => "Numeric Range"),
            array("id" => "2", "name" => "Alphanumeric Values"),
            array("id" => "3", "name" => "Autocomplete"),
            array("id" => "4", "name" => "Free Text")
        );

        foreach ($measure_types as $measure_type)
        {
            MeasureType::create($measure_type);
        }
        $this->command->info('measure_types seeded');
                
        /* Measures table */
        
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
            array("measure_type_id" => "4", "name" => "GXM", "measure_range" => "", "unit" => ""),
            array("measure_type_id" => "2", "name" => "Indirect COOMBS test", "measure_range" => "Positive/Negative", "unit" => ""),
            array("measure_type_id" => "2", "name" => "Direct COOMBS test", "measure_range" => "Positive/Negative", "unit" => ""),
            array("measure_type_id" => "2", "name" => "Du test", "measure_range" => "Positive/Negative", "unit" => ""),
            array("measure_type_id" => "2", "name" => "Blood Grouping", "measure_range" => "O-/O+/A-/A+/B-/B+/AB-/AB+", "unit" => "")
        );

        foreach ($measures as $measure)
        {
            Measure::create($measure);
        }
        $this->command->info('measures seeded');
        
        /* Test Types table */
        $test_types = TestType::create(array("name" => "BS for mps", "section_id" => $test_categories->id));
        $this->command->info('test_types seeded');
        
        /* Patients table */
        $patients = Patient::create(
            array(
                "name" => "Jamkizi Felix", 
                "email" => "fjamkizi@example.com", 
                "patient_number" => "1002"
            )
        );
        $this->command->info('patients seeded');

        /* Test Phase table */
        $test_phases = TestPhase::create(array("name" => "whoolan"));
        $this->command->info('test_phases seeded');

        /* Test Status table */
        $test_statuses = TestStatus::create(array("name" => "booh!","test_phase_id" => $test_phases->id));
        $this->command->info('test_statuses seeded');

        /* Specimen Status table */
        $specimen_statuses = SpecimenStatus::create(array("name" => "boohdan"));
        $this->command->info('specimen_statuses seeded');

        /* Visits table */
        $visits = Visit::create(array("patient_id" => $patients->id));
        $this->command->info('visits seeded');

        /* Rejection Reasons table */
        $rejection_reasons = RejectionReason::create(array("reason" => "Looked Funny!"));
        $this->command->info('rejection_reasons seeded');

        /* Specimen table */
        $specimens = Specimen::create(
            array(
                "specimen_type_id" => $specimen_types->id,
                "specimen_status_id" => $specimen_statuses->id,
                "rejection_reason_id" => $rejection_reasons->id,
                "test_phase_id" => $test_phases->id,
            )
        );        
        $this->command->info('specimens seeded');

        /* Test table */
        $tests = Test::create(
            array(
                "visit_id" => $visits->id,
                "test_type_id" => $test_types->id,
                "specimen_id" => $specimens->id,
                "interpretation" => "Budda Boss",
                "test_status_id" => $test_statuses->id,
            )
        );        
        $this->command->info('tests seeded');
    }
}