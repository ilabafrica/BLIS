<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Configurable;
use App\Models\Field;
use App\Models\LabConfig;

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
            )
        );
        /* Configurable-fields table */
        $fields = array(
            array(
                "field_name" => "Encoding Format", "field_type" => "3", "user_id" => "1", "configurable_id" => "1", "options" => "ean8,ean13,code11,code39,code128,codabar,std25,int25,code93", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Barcode Width", "field_type" => "3", "user_id" => "1", "configurable_id" => "1", "options" => "1,2,3,4,5,6,7,8,9,10", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Barcode Height", "field_type" => "3", "user_id" => "1", "configurable_id" => "1", "options" => "5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80", "created_at" => $now, "updated_at" => $now
            ),
            array(
                "field_name" => "Text Size", "field_type" => "3", "user_id" => "1", "configurable_id" => "1", "options" => "5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39", "created_at" => $now, "updated_at" => $now
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
        foreach ($settings as $setting)
        {
            $array[] = LabConfig::create($setting);
        }
        $this->command->info('Settings table seeded');
    }
}
