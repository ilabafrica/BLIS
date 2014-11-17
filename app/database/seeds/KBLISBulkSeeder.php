<?php

class KBLISBulkSeeder extends DatabaseSeeder
{
    public function run()
    {
        /* Users table */
        foreach (UserSeed::get() as $user)
        {
            User::create($user);
        }
        $this->command->info('users seeded');

        /* Specimen Types table */
        foreach (SpecimenTypeSeed::get() as $specimen_type)
        {
            SpecimenType::create($specimen_type);
        }
        $this->command->info('specimen_types seeded');

        /* Test Categories table */
        foreach (TestCategorySeed::get() as $test_category)
        {
            TestCategory::create($test_category);
        }
        $this->command->info('specimen_types seeded');
        
        /* Measure Types */
        foreach (MeasureTypeSeed::get() as $measure_type)
        {
            MeasureType::create($measure_type);
        }
        $this->command->info('measure_types seeded');
                
        /* Measures table */
        foreach (MeasureSeed::get() as $measure)
        {
            Measure::create($measure);
        }
        $this->command->info('measures seeded');
        
        /* Test Types table */
        foreach (TestTypeSeed::get() as $test_type)
        {
            TestType::create($test_type);
        }
        $this->command->info('test_types seeded');

        /* TestType Measure table */
        foreach (TestTypeMeasureSeed::get() as $testtype_measure)
        {
            TestTypeMeasure::create($testtype_measure);
        }
        $this->command->info('testtype_measures seeded');

        /* testtype_specimentypes table */
        foreach (TesttypeSpecimentypeSeed::get() as $testtype_specimentype)
        {
            DB::insert('INSERT INTO testtype_specimentypes (test_type_id, specimen_type_id) VALUES (?, ?)', 
                $testtype_specimentype
            );
        }
        $this->command->info('testtype_specimentypes seeded');

        /* Patients table */
        foreach (PatientSeed::get() as $patient) 
        {
            Patient::create($patient);
        }
        $this->command->info('patients seeded');

        /* Test Phase table */
        foreach (TestPhaseSeed::get() as $test_phase)
        {
            TestPhase::create($test_phase);
        }
        $this->command->info('test_phases seeded');

        /* Test Status table */
        foreach (TestStatusSeed::get() as $test_status)
        {
            TestStatus::create($test_status);
        }
        $this->command->info('test_statuses seeded');

        /* Specimen Status table */
        foreach (SpecimenStatusSeed::get() as $specimen_status)
        {
            SpecimenStatus::create($specimen_status);
        }
        $this->command->info('specimen_statuses seeded');

        /* Visits table */
        foreach (VisitSeed::get() as $visit)
        {
            Visit::create($visit);
        }
        $this->command->info('visits seeded');

        /* Rejection Reasons table */
        foreach (RejectionReasonSeed::get() as $rejection_reason)
        {
            RejectionReason::create($rejection_reason);
        }
        $this->command->info('rejection_reasons seeded');

        /* Specimen table */
        foreach (SpecimenSeed::get() as $specimen)
        {
            Specimen::create($specimen);
        }
        $this->command->info('specimens seeded');

        /* Test table */
        foreach (TestSeed::get() as $test)
        {
            Test::create($test);
        }
        $this->command->info('tests seeded');

        /* Test Results table */
        foreach (TestResultSeed::get() as $test_result)
        {
            TestResult::create($test_result);
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
            array("name" => "view_names", "display_name" => "Can view patient names"),
            array("name" => "manage_patients", "display_name" => "Can add patients"),

            array("name" => "receive_external_test", "display_name" => "Can receive test requests"),
            array("name" => "request_test", "display_name" => "Can request new test"),
            array("name" => "accept_test_specimen", "display_name" => "Can accept test specimen"),
            array("name" => "reject_test_specimen", "display_name" => "Can reject test specimen"),
            array("name" => "change_test_specimen", "display_name" => "Can change test specimen"),
            array("name" => "start_test", "display_name" => "Can start tests"),
            array("name" => "enter_test_results", "display_name" => "Can enter tests results"),
            array("name" => "edit_test_results", "display_name" => "Can edit test results"),
            array("name" => "verify_test_results", "display_name" => "Can verify test results"),
            array("name" => "send_results_to_external_system", "display_name" => "Can send test results to external systems"),

            array("name" => "manage_users", "display_name" => "Can manage users"),
            array("name" => "manage_test_catalog", "display_name" => "Can manage test catalog"),
            array("name" => "manage_lab_configurations", "display_name" => "Can manage lab configurations"),
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
