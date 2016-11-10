<?php

class CatalogConfigSeeder extends DatabaseSeeder
{
    public function run()
    {
        /*====================*/
        /*1. Seed test categories*/
        /*====================*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/test_categories.sql');

        //if (! str_contains($sql, ['DELETE', 'TRUNCATE'])) {
        //    throw new Exception('Invalid sql file. This will not empty the tables first.');
       // }

        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
         $this->command->info('Test Categories seeded');

        /*=================*/
        /*2. Seed Sample types*/
        /*=================*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/sample_types.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Sample Types seeded');

        /*===============*/
        /*3. Seed test types*/
        /*===============*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/test_types.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Test types seeded');

        /*=============*/
        /*4. Seed Measures*/
        /*=============*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/measures.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Measures seeded');

        /*===================*/
        /*5. Seed Measure Ranges*/
        /*===================*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/measure_ranges.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Measure Ranges seeded');

        /*==============*/
        /*6. Seed Organisms*/
        /*==============*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/organisms.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Organisms seeded');

        /*==========*/
        /*7. Seed Drugs*/
        /*==========*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/drugs.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Drugs seeded');

        /*============*/
        /*8. Seed Disease*/
        /*============*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/diseases.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Diseases seeded');

        /*====================*/
        /*9. Seed Organisms_drugs*/
        /*====================*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/organisms_drugs.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Organisms Drugs seeded');

        /*===========================*/
        /*10. Seed Testtype_specimentype*/
        /*===========================*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/testtype_specimentype.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Testtype_specimentype seeded');

        /*======================*/
        /*11. Seed Testtype_measures*/
        /*======================*/
        // Note: these dump files must be generated with DELETE (or TRUNCATE) + INSERT statements
        $sql = file_get_contents(__DIR__ . '/output_sql/testtype_measures.sql');

        
        // split the statements, so DB::statement can execute them.
        $statements = array_filter(array_map('trim', explode(';', $sql)));

        foreach ($statements as $stmt) {
            DB::statement($stmt);
        }
        $this->command->info('Testtype_measures seeded');

       /*======================*/
        /* Instruments table */
        /*======================*/
        $id = DB::table('test_types')->where('name', 'White blood cells')->pluck('id');
        $this->command->info('test_statuses seeded'.$id);
        $instrumentsData = array(
            "name" => "Celltac F Mek 8222",
            "description" => "Automatic analyzer with 22 parameters and WBC 5 part diff Hematology Analyzer",
            "driver_name" => "KBLIS\\Plugins\\CelltacFMachine",
            "ip" => "192.168.1.12",
            "hostname" => "HEMASERVER"
        );
        
        $instrument = Instrument::create($instrumentsData);
        $instrument->testTypes()->attach(array($id));

        $this->command->info('Instruments table seeded');

        /*======================*/
        //Seeding for QC
        /*======================*/
        $lots = array(
            array('lot_no'=> '0001',
                'description' => 'First lot',
                'expiry' => date('Y-m-d H:i:s', strtotime("+6 months"))),
            array('lot_no'=> '0002',
                'description' => 'Second lot',
                'expiry' => date('Y-m-d H:i:s', strtotime("+7 months")))
        );
        foreach ($lots as $lot) {
            $lot = Lot::create($lot);
        }
        $this->command->info("Lot table seeded");

        /*======================*/
        //Control seeding
        /*======================*/
        $controls = array(
            array('name'=>'Humatrol P', 
                    'description' =>'HUMATROL P control serum has been designed to provide a suitable basis for the quality control (imprecision, inaccuracy) in the clinical chemical laboratory.', 
                    'instrument_id' => 1),
            array('name'=>'Full Blood Count', 'description' => 'Né pas touchér', 'instrument_id' => 1,)
            );
        foreach ($controls as $control) {
            Control::create($control);
        }
        $this->command->info("Control table seeded");

        /*======================*/
        //Control measures
        /*======================*/
        $controlMeasures = array(
                    //Humatrol P
                    array('name' => 'ca', 'unit' => 'mmol', 'control_id' => 1, 'control_measure_type_id' => 1),
                    array('name' => 'pi', 'unit' => 'mmol', 'control_id' => 1, 'control_measure_type_id' => 1),
                    array('name' => 'mg', 'unit' => 'mmol', 'control_id' => 1, 'control_measure_type_id' => 1),
                    array('name' => 'na', 'unit' => 'mmol', 'control_id' => 1, 'control_measure_type_id' => 1),
                    array('name' => 'K', 'unit' => 'mmol', 'control_id' => 1, 'control_measure_type_id' => 1),

                    //Full Blood Count
                    array('name' => 'WBC', 'unit' => 'x 103/uL', 'control_id' => 2, 'control_measure_type_id' => 1),
                    array('name' => 'RBC', 'unit' => 'x 106/uL', 'control_id' => 2, 'control_measure_type_id' => 1),
                    array('name' => 'HGB', 'unit' => 'g/dl', 'control_id' => 2, 'control_measure_type_id' => 1),
                    array('name' => 'HCT', 'unit' => '%', 'control_id' => 2, 'control_measure_type_id' => 1),
                    array('name' => 'MCV', 'unit' => 'fl', 'control_id' => 2, 'control_measure_type_id' => 1),
                    array('name' => 'MCH', 'unit' => 'pg', 'control_id' => 2, 'control_measure_type_id' => 1),
                    array('name' => 'MCHC', 'unit' => 'g/dl', 'control_id' => 2, 'control_measure_type_id' => 1),
                    array('name' => 'PLT', 'unit' => 'x 103/uL', 'control_id' => 2, 'control_measure_type_id' => 1),
            );
        foreach ($controlMeasures as $controlMeasure) {
            ControlMeasure::create($controlMeasure);
        }
        $this->command->info("Control Measure table seeded");

        //Control measure ranges
        $controlMeasureRanges = array(
                //Humatrol P
                array('upper_range' => '2.63', 'lower_range' => '7.19', 'control_measure_id' => 1),
                array('upper_range' => '11.65', 'lower_range' => '15.43', 'control_measure_id' => 2),
                array('upper_range' => '12.13', 'lower_range' => '19.11', 'control_measure_id' => 3),
                array('upper_range' => '15.73', 'lower_range' => '25.01', 'control_measure_id' => 4),
                array('upper_range' => '17.63', 'lower_range' => '20.12', 'control_measure_id' => 5),

                //Full blood count
                array('upper_range' => '6.5', 'lower_range' => '7.5', 'control_measure_id' => 6),
                array('upper_range' => '4.36', 'lower_range' => '5.78', 'control_measure_id' => 7),
                array('upper_range' => '13.8', 'lower_range' => '17.3', 'control_measure_id' => 8),
                array('upper_range' => '81.0', 'lower_range' => '95.0', 'control_measure_id' => 9),
                array('upper_range' => '1.99', 'lower_range' => '2.63', 'control_measure_id' => 10),
                array('upper_range' => '27.6', 'lower_range' => '33.0', 'control_measure_id' => 11),
                array('upper_range' => '32.8', 'lower_range' => '36.4', 'control_measure_id' => 12),
                array('upper_range' => '141', 'lower_range' => ' 320.0', 'control_measure_id' => 13)
            );
        foreach ($controlMeasureRanges as $controlMeasureRange) {
            ControlMeasureRange::create($controlMeasureRange);
        }
        $this->command->info("Control Measure ranges table seeded");

        //Control Tests
        $controlTests = array(
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Msiska', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-10 days'))),
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Katayi', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-9 days'))),
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Msiska', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-8 days'))),
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Kweyu', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-7 days'))),
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Kweyu', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-6 days'))),
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Tiwonge', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-5 days'))),
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Mukulu', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-4 days'))),
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Tiwonge', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),
                array('control_id'=> 1, 'lot_id'=> 1, 'performed_by'=> 'Tiwonge', 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
            );
        foreach ($controlTests as $controltest) {
            ControlTest::create($controltest);
        }
        $this->command->info("Control test table seeded");

        //Control results
        $controlResults = array(
                //Results fro Humatrol P
                array('results' => '2.78', 'control_measure_id' => 1, 'control_test_id' => 1, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-10 days'))),
                array('results' => '13.56', 'control_measure_id' => 2, 'control_test_id' => 1, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-10 days'))),
                array('results' => '14.77', 'control_measure_id' => 3, 'control_test_id' => 1, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-10 days'))),
                array('results' => '25.92', 'control_measure_id' => 4, 'control_test_id' => 1, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-10 days'))),
                array('results' => '18.87', 'control_measure_id' => 5, 'control_test_id' => 1, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-10 days'))),

                 //Results fro Humatrol P
                array('results' => '6.78', 'control_measure_id' => 1, 'control_test_id' => 2, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-9 days'))),
                array('results' => '15.56', 'control_measure_id' => 2, 'control_test_id' => 2, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-9 days'))),
                array('results' => '18.77', 'control_measure_id' => 3, 'control_test_id' => 2, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-9 days'))),
                array('results' => '30.92', 'control_measure_id' => 4, 'control_test_id' => 2, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-9 days'))),
                array('results' => '17.87', 'control_measure_id' => 5, 'control_test_id' => 2, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-9 days'))),

                 //Results fro Humatrol P
                array('results' => '8.78', 'control_measure_id' => 1, 'control_test_id' => 3, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-8 days'))),
                array('results' => '17.56', 'control_measure_id' => 2, 'control_test_id' => 3, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-8 days'))),
                array('results' => '21.77', 'control_measure_id' => 3, 'control_test_id' => 3, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-8 days'))),
                array('results' => '27.92', 'control_measure_id' => 4, 'control_test_id' => 3, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-8 days'))),
                array('results' => '22.87', 'control_measure_id' => 5, 'control_test_id' => 3, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-8 days'))),

                 //Results fro Humatrol P
                array('results' => '6.78', 'control_measure_id' => 1, 'control_test_id' => 4, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-7 days'))),
                array('results' => '18.56', 'control_measure_id' => 2, 'control_test_id' => 4, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-7 days'))),
                array('results' => '19.77', 'control_measure_id' => 3, 'control_test_id' => 4, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-7 days'))),
                array('results' => '12.92', 'control_measure_id' => 4, 'control_test_id' => 4, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-7 days'))),
                array('results' => '22.87', 'control_measure_id' => 5, 'control_test_id' => 4, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-7 days'))),

                 //Results fro Humatrol P
                array('results' => '3.78', 'control_measure_id' => 1, 'control_test_id' => 5, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-6 days'))),
                array('results' => '16.56', 'control_measure_id' => 2, 'control_test_id' => 5, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-6 days'))),
                array('results' => '17.77', 'control_measure_id' => 3, 'control_test_id' => 5, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-6 days'))),
                array('results' => '28.92', 'control_measure_id' => 4, 'control_test_id' => 5, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-6 days'))),
                array('results' => '19.87', 'control_measure_id' => 5, 'control_test_id' => 5, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-6 days'))),

                 //Results fro Humatrol P
                array('results' => '5.78', 'control_measure_id' => 1, 'control_test_id' => 6, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-5 days'))),
                array('results' => '15.56', 'control_measure_id' => 2, 'control_test_id' => 6, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-5 days'))),
                array('results' => '11.77', 'control_measure_id' => 3, 'control_test_id' => 6, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-5 days'))),
                array('results' => '29.92', 'control_measure_id' => 4, 'control_test_id' => 6, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-5 days'))),
                array('results' => '14.87', 'control_measure_id' => 5, 'control_test_id' => 6, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-5 days'))),

                 //Results fro Humatrol P
                array('results' => '9.78', 'control_measure_id' => 1, 'control_test_id' => 7, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-4 days'))),
                array('results' => '11.56', 'control_measure_id' => 2, 'control_test_id' => 7, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-4 days'))),
                array('results' => '19.77', 'control_measure_id' => 3, 'control_test_id' => 7, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-4 days'))),
                array('results' => '32.92', 'control_measure_id' => 4, 'control_test_id' => 7, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-4 days'))),
                array('results' => '29.87', 'control_measure_id' => 5, 'control_test_id' => 7, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-4 days'))),

                //Results for Full blood count
                array('results' => '5.45', 'control_measure_id' => 6, 'control_test_id' => 8, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),
                array('results' => '5.01', 'control_measure_id' => 7, 'control_test_id' => 8, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),
                array('results' => '12.3', 'control_measure_id' => 8, 'control_test_id' => 8, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),
                array('results' => '89.7', 'control_measure_id' => 9, 'control_test_id' => 8, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),
                array('results' => '2.15', 'control_measure_id' => 10, 'control_test_id' => 8, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),
                array('results' => '34.0', 'control_measure_id' => 11, 'control_test_id' => 8, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),
                array('results' => '37.2', 'control_measure_id' => 12, 'control_test_id' => 8, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),
                array('results' => '141.5', 'control_measure_id' => 13, 'control_test_id' => 8, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-3 days'))),

                //Results for Full blood count
                array('results' => '7.45', 'control_measure_id' => 6, 'control_test_id' => 9, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
                array('results' => '9.01', 'control_measure_id' => 7, 'control_test_id' => 9, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
                array('results' => '9.3',  'control_measure_id' => 8, 'control_test_id' => 9, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
                array('results' => '94.7', 'control_measure_id' => 9, 'control_test_id' => 9, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
                array('results' => '12.15','control_measure_id' => 10, 'control_test_id' => 9, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
                array('results' => '37.0', 'control_measure_id' => 11, 'control_test_id' => 9, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
                array('results' => '30.2', 'control_measure_id' => 12, 'control_test_id' => 9, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
                array('results' => '121.5','control_measure_id' =>  13, 'control_test_id' => 9, 'user_id'=> 1, 'created_at'=>date('Y-m-d', strtotime('-2 days'))),
            );
        
        foreach ($controlResults as $controlResult) {
            ControlMeasureResult::create($controlResult);
        }
        $this->command->info("Control results table seeded");

    }
}
