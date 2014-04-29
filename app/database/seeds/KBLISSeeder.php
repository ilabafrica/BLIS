<?php

class KBLISSeeder
extends DatabaseSeeder
{
    public function run()
    {
        DB::table('user')->delete();
        
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

        DB::table('specimen_type')->delete();
        
        $specTypes = array(
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

        foreach ($specTypes as $specType)
        {
            SpecimenType::create($specType);
        }
		
		DB::table('test_category')->delete();
        
        $test_categories = array(
			array("name" => "HAEMATOLOGY","description" => ""),
			array("name" => "MCH","description" => ""),
			array("name" => "VIROLOGY","description" => ""),
			array("name" => "HISTOLOGY AND CYTOLOGY","description" => ""),
			array("name" => "BIOCHEMISTRY","description" => ""),
			array("name" => "MICROBIOLOGY","description" => ""),
			array("name" => "OTHER","description" => ""),
			array("name" => "CLINICAL CHEMISTRY","description" => "")
        );

        foreach ($test_categories as $test_category)
        {
            TestCategory::create($test_category);
        }
		
		DB::table('measure')->delete();
        
        $measures = array(
		
			array("name" => "Grams stain", "measure_range" => "Positive/Negative", "unit" => ""),
			array("name" => "SERUM AMYLASE", "measure_range" => "Low/Normal/High", "unit" => ""),
			array("name" => "calcium", "measure_range" => "Low/Normal/High", "unit" => ""),
			array("name" => "URIC ACID", "measure_range" => "", "unit" => "mg/dl"),
			array("name" => "CSF for biochemistry", "measure_range" => "", "unit" => ""),
			array("name" => "PSA", "measure_range" => "", "unit" => ""),
			array("name" => "Total", "measure_range" => "", "unit" => "mg/dl"),
			array("name" => "Alkaline Phosphate", "measure_range" => "", "unit" => "u/l"),
			array("name" => "SGOT", "measure_range" => "Low/Normal/High", "unit" => ""),
			array("name" => "Direct", "measure_range" => "", "unit" => "mg/dl"),
			array("name" => "Total Proteins", "measure_range" => "", "unit" => ""),
			array("name" => "LFTS", "measure_range" => "", "unit" => "NULL"),
			array("name" => "Chloride", "measure_range" => "", "unit" => "mmol/l"),
			array("name" => "Potassium", "measure_range" => "", "unit" => "mmol/l"),
			array("name" => "Sodium", "measure_range" => "", "unit" => "mmol/l"),
			array("name" => "Electrolytes", "measure_range" => "", "unit" => ""),
			array("name" => "Creatinine", "measure_range" => "", "unit" => "mg/dl"),
			array("name" => "Urea", "measure_range" => "", "unit" => "mg/dl"),
			array("name" => "RFTS", "measure_range" => "", "unit" => ""),
			array("name" => "TFT", "measure_range" => "", "unit" => ""),
			array("name" => "GXM", "measure_range" => "", "unit" => ""),
			array("name" => "Indirect COOMBS test", "measure_range" => "Positive/Negative", "unit" => ""),
			array("name" => "Direct COOMBS test", "measure_range" => "Positive/Negative", "unit" => ""),
			array("name" => "Du test", "measure_range" => "Positive/Negative", "unit" => ""),
			array("name" => "Blood Grouping", "measure_range" => "O-/O+/A-/A+/B-/B+/AB-/AB+", "unit" => "")
        );

        foreach ($measures as $measure)
        {
            Measure::create($measure);
        }
		
    }
}