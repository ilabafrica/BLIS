<?php

class ITECHDatabaseSeeder extends DatabaseSeeder
{
    public function run()
    {
        /* Users table 
        $usersData = array(
            array(
                "username" => "administrator", "password" => Hash::make("password"), "email" => "admin@kblis.org",
                "name" => "kBLIS Administrator", "designation" => "Programmer"
            ),
            
        );

        foreach ($usersData as $user)
        {
            $users[] = User::create($user);
        }
        $this->command->info('users seeded');
        
        //Seed for suppliers
        $supplier = Supplier::create(
            array(
                "name" => "UNICEF",
                "phone_no" => "0775112233",
                "email" => "uni@unice.org",
                "physical_address" => "un-hqtr"

            )
        );
        $this->command->info('Suppliers table seeded');
        */

        //Seed for metrics
        $metric = Metric::create(
            array(
                "name" => "mg",
                "description" => "milligram"
            )
        );
        $this->command->info('Metrics table seeded');

        //Seed for commodities
        $commodity = Commodity::create(
            array(
                "name" => "Ampicillin",
                "description" => "Capsule 250mg",
                "metric_id" => $metric->id,
                "unit_price" => "500",
                "item_code" => "no clue",
                "storage_req" => "no clue",
                "min_level" => "100000",
                "max_level" => "400000")
        );
        $this->command->info('Commodities table seeded');
        
        //Seed for receipts
        $receipt = Receipt::create(
            array(
                "commodity_id" => $commodity->id,
                "supplier_id" => $supplier->id, 
                "quantity" => "130000",
                "batch_no" => "002720",
                "expiry_date" => "2018-10-14", 
                "user_id" => "1")
        );
        $this->command->info('Receipts table seeded');
        
        //Seed for Top Up Request
        $topUpRequest = TopupRequest::create(
            array(
                "commodity_id" => $commodity->id,
                "test_category_id" => 1,
                "order_quantity" => "1500",
                "user_id" => 1,
                "remarks" => "-")
        );
        $this->command->info('Top Up Requests table seeded');

        //Seed for Issues
        Issue::create(
            array(
                "receipt_id" => $receipt->id,
                "topup_request_id" => $topUpRequest->id,
                "quantity_issued" => "1700",
                "issued_to" => 1,
                "user_id" => 1,
                "remarks" => "-")
        );
        $this->command->info('Issues table seeded');

        //Seed for diseases
        $malaria = Disease::create(array('name' => "Malaria"));
        $typhoid = Disease::create(array('name' => "Typhoid"));
        $dysentry = Disease::create(array('name' => "Shigella Dysentry"));

        $this->command->info("Dieases table seeded");

        $reportDiseases = array(
            array(
                "test_type_id" => $testTypeBS->id,
                "disease_id" => $malaria->id,
                ),
             array(
                "test_type_id" => $test_types_salmonella->id,
                "disease_id" => $typhoid->id,
                ),
             array(
                "test_type_id" => $testTypeStoolCS->id,
                "disease_id" => $dysentry->id,
                ),
        );

        foreach ($reportDiseases as $reportDisease) {
            ReportDisease::create($reportDisease);
        }
        $this->command->info("Report Disease table seeded");

        //Seeding for QC
        $lots = array(
            array('number'=> '0001',
                'description' => 'First lot',
                'expiry' => date('Y-m-d H:i:s', strtotime("+6 months")),
                'instrument_id' => 1),
            array('number'=> '0002',
                'description' => 'Second lot',
                'expiry' => date('Y-m-d H:i:s', strtotime("+7 months")),
                'instrument_id' => 1));
        foreach ($lots as $lot) {
            $lot = Lot::create($lot);
        }
        $this->command->info("Lot table seeded");
    }

}

