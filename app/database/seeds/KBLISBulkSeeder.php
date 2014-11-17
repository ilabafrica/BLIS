<?php

class KBLISBulkSeeder extends DatabaseSeeder
{
    public function run()
    {
        /* Users table */
        foreach (Seed::getUser() as $user)
        {
            User::create($user);
        }
        $this->command->info('users seeded');

        /* Specimen Types table */
        foreach (Seed::getSpecimenType() as $specimen_type)
        {
            SpecimenType::create($specimen_type);
        }
        $this->command->info('specimen_types seeded');

        /* Test Categories table */
        foreach (Seed::getTestCategory() as $test_category)
        {
            TestCategory::create($test_category);
        }
        $this->command->info('specimen_types seeded');
        
        /* Measure Types */
        foreach (Seed::getMeasureType() as $measure_type)
        {
            MeasureType::create($measure_type);
        }
        $this->command->info('measure_types seeded');
                
        /* Measures table */
        foreach (Seed::getMeasure() as $measure)
        {
            Measure::create($measure);
        }
        $this->command->info('measures seeded');
        
        /* Test Types table */
        foreach (Seed::getTestType() as $test_type)
        {
            TestType::create($test_type);
        }
        $this->command->info('test_types seeded');

        /* TestType Measure table */
        foreach (Seed::getTestTypeMeasure() as $testtype_measure)
        {
            TestTypeMeasure::create($testtype_measure);
        }
        $this->command->info('testtype_measures seeded');

        /* testtype_specimentypes table */
        foreach (Seed::getTesttypeSpecimentype() as $testtype_specimentype)
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
        foreach (Seed::getTestPhase() as $test_phase)
        {
            TestPhase::create($test_phase);
        }
        $this->command->info('test_phases seeded');

        /* Test Status table */
        foreach (Seed::getTestStatus() as $test_status)
        {
            TestStatus::create($test_status);
        }
        $this->command->info('test_statuses seeded');

        /* Specimen Status table */
        foreach (Seed::getSpecimenStatus() as $specimen_status)
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
        foreach (Seed::getRejectionReason() as $rejection_reason)
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
        foreach (Seed::getReferral() as $ref) {
            DB::insert("INSERT INTO referrals (referring_institution) VALUES (?)", $ref);
        }

        $this->command->info('referrals seeded');
        /* Permissions table */
        foreach (Seed::getPermission() as $permission) {
            Permission::create($permission);
        }
        $this->command->info('Permissions table seeded');

        /* Roles table */
        foreach (Seed::getRole() as $role) {
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
