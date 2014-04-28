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
		
    }
}