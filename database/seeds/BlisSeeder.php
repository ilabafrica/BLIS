<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Configurable;
use App\Models\Field;
use App\Models\LabConfig;
use App\Models\Analyser;
use App\Models\ConField;
use App\Models\TestCategory;

//	Carbon - for use with dates
use Jenssegers\Date\Date as Carbon;

class BlisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = Carbon::today()->toDateTimeString();
        /* Users table */
        $usersData = array(
            array(
                "username" => "admin", "password" => Hash::make("password"), "email" => "admin@blis.org",
                "name" => "BLIS Administrator", "gender" => "1", "phone"=>"0722000000", "address" => "P.O. Box 59857-00200, Nairobi", "created_at" => $now, "updated_at" => $now
            )
        );
        /* Configurables table */
        $configurables = array(
            array(
                "name" => "Barcode Settings", "Description" => "", "route" => "barcode", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "name" => "Laboratory Settings", "Description" => "", "route" => "lab", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            )
        );
        /* fields table */
        $fields = array(
        	// Barcode fields
            array(
                "field_name" => "Encoding Format", "field_type" => "3", "user_id" => "1", "options" => "ean8,ean13,code11,code39,code128,codabar,std25,int25,code93", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Barcode Width", "field_type" => "3", "user_id" => "1", "options" => "1,2,3,4,5,6,7,8,9,10", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Barcode Height", "field_type" => "3", "user_id" => "1", "options" => "5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Text Size", "field_type" => "3", "user_id" => "1", "options" => "5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39", "created_at" => $now, "updated_at" => $now
            ),
            // Lab settings fields
            array(
                "field_name" => "Laboratory Logo", "field_type" => "1", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Laboratory Name", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Telephone", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Address", "field_type" => "5", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Email", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Website", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Director", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Manager", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Quality Manager", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            )
            // interfaced equipment
            ,
            array(
                "field_name" => "PORT", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "MODE", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "CLIENT_RECONNECT", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "EQUIPMENT_IP", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "COMPORT", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "BAUD_RATE", "field_type" => "3", "user_id" => "1", "options" => "300,1200,2400,4800,9600,14400,19200,28800,38400,57600,115200,230400", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "PARITY", "field_type" => "3", "user_id" => "1", "options" => "None,Odd,Even", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "STOP_BITS", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "APPEND_NEWLINE", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "DATA_BITS", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "APPEND_CARRIAGE_RETURN", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "DATASOURCE", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "DAYS", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "BASE_DIRECTORY", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "USE_SUB_DIRECTORIES", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "SUB_DIRECTORY_FORMAT", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "FILE_NAME_FORMAT", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "FILE_EXTENSION", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "FILE_SEPERATOR", "field_type" => "4", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            )
        );
		/* configurable-fields table */
		$confields = array(
			array(
				"configurable_id" => 1, "field_id" => 1, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 1, "field_id" => 2, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 1, "field_id" => 3, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 1, "field_id" => 4, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 5, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 6, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 7, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 8, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 9, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 10, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 11, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 12, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			),
			array(
				"configurable_id" => 2, "field_id" => 13, "user_id" => "1", "created_at" => $now, "updated_at" => $now
			)
		);
        /* lab-config-settings table */
        $settings = array(
            array(
                "key" => "1", "value" => "code39", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "key" => "2", "value" => "2", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "key" => "3", "value" => "30", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "key" => "4", "value" => "11", "user_id" => "1", "created_at" => $now, "updated_at" => $now
            )
        );
        foreach ($usersData as $user)
        {
            $users[] = User::create($user);
        }
        $this->command->info('Users table seeded');
        foreach ($configurables as $configurable)
        {
            $data[] = Configurable::create($configurable);
        }
        $this->command->info('Configurables table seeded');
        foreach ($fields as $field)
        {
            $configs[] = Field::create($field);
        }
        $this->command->info('Fields table seeded');
        foreach ($confields as $confield)
        {
            $conf[] = ConField::create($confield);
        }
        $this->command->info('Fields table seeded');
        foreach ($settings as $setting)
        {
            $array[] = LabConfig::create($setting);
        }
        $this->command->info('Settings table seeded');
        /* Test Categories table - These map on to the lab sections */
        $test_categories = TestCategory::create(array("name" => "PARASITOLOGY","description" => "", "created_at" => $now, "updated_at" => $now));
        $lab_section_microbiology = TestCategory::create(array("name" => "MICROBIOLOGY","description" => "", "created_at" => $now, "updated_at" => $now));

        $this->command->info('Test categories seeded');
    }
}
