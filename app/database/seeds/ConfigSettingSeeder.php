<?php

class ConfigSettingSeeder extends DatabaseSeeder
{
    public function run()
    {
        //  Seed for barcode
        $barcode = array("encoding_format" => 'code39', "barcode_width" => '2', "barcode_height" => '30', "text_size" => '11');
        Barcode::create($barcode);
        $this->command->info("Barcode table seeded");
        //  Seed for quick codes
        $quick = array(
            array("feed_source" => 1, "config_prop" => 'PORT', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 1, "config_prop" => 'MODE', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 1, "config_prop" => 'CLIENT_RECONNECT', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 1, "config_prop" => 'EQUIPMENT_IP', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 0, "config_prop" => 'COMPORT', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 0, "config_prop" => 'BAUD_RATE', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 0, "config_prop" => 'PARITY', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 0, "config_prop" => 'STOP_BITS', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 0, "config_prop" => 'APPEND_NEWLINE', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 0, "config_prop" => 'DATA_BITS', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 0, "config_prop" => 'APPEND_CARRIAGE_RETURN', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 2, "config_prop" => 'DATASOURCE', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 2, "config_prop" => 'DAYS', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 4, "config_prop" => 'BASE_DIRECTORY', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 4, "config_prop" => 'USE_SUB_DIRECTORIES', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 4, "config_prop" => 'SUB_DIRECTORY_FORMAT', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 4, "config_prop" => 'FILE_NAME_FORMAT', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 4, "config_prop" => 'FILE_EXTENSION', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("feed_source" => 4, "config_prop" => 'FILE_SEPERATOR', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            );
        foreach ($quick as $codes)
        {
            DB::table('ii_quickcodes')->insert($codes);
        }
        $this->command->info("Quick codes table seeded");
        //  Seed for interfaced equipment in blis client
        $equipment = array(
            array("equipment_name" => 'Mindray BS-200E', "comm_type" => 2, "equipment_version" => '01.00.07', "lab_section" => 1, "feed_source" => 1, "config_file" => '\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000pluschameleon.xml'),
            array("equipment_name" => 'ABX Pentra 60 C+', "comm_type" => 2, "equipment_version" => '', "lab_section" => 1, "feed_source" => 2, "config_file" => '\\BLISInterfaceClient\\configs\\pentra\\pentra60cplus.xml'),
            array("equipment_name" => 'ABX MACROS 60', "comm_type" => 1, "equipment_version" => '', "lab_section" => 1, "feed_source" => 0, "config_file" => '\\BLISInterfaceClient\\configs\\micros60\\abxmicros60.xml'),
            array("equipment_name" => 'BT 3000 Plus', "comm_type" => 1, "equipment_version" => '', "lab_section" => 1, "feed_source" => 0, "config_file" => '\\BLISInterfaceClient\\configs\\BT3000Plus\\bt3000plus.xml'),
            array("equipment_name" => 'Sysmex SX 500i', "comm_type" => 1, "equipment_version" => '', "lab_section" => 1, "feed_source" => 1, "config_file" => '\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXS500i.xml'),
            array("equipment_name" => 'BD FACSCalibur', "comm_type" => 1, "equipment_version" => '', "lab_section" => 1, "feed_source" => 4, "config_file" => '\\BLISInterfaceClient\\configs\\BDFACSCalibur\\bdfacscalibur.xml'),
            array("equipment_name" => 'Mindray BC 3600', "comm_type" => 1, "equipment_version" => '', "lab_section" => 1, "feed_source" => 0, "config_file" => '\\BLISInterfaceClient\\configs\\mindray\\mindraybc3600.xml'),
            array("equipment_name" => 'Selectra Junior', "comm_type" => 1, "equipment_version" => '', "lab_section" => 1, "feed_source" => 0, "config_file" => '\\BLISInterfaceClient\\configs\\selectrajunior\\selectrajunior.xml'),
            array("equipment_name" => 'GeneXpert', "comm_type" => 2, "equipment_version" => '', "lab_section" => 1, "feed_source" => 1, "config_file" => '\\BLISInterfaceClient\\configs\\geneXpert\\genexpert.xml'),
            array("equipment_name" => 'ABX Pentra 80', "comm_type" => 2, "equipment_version" => '', "lab_section" => 1, "feed_source" => 0, "config_file" => '\\BLISInterfaceClient\\configs\\pentra80\\abxpentra80.xml'),
            array("equipment_name" => 'Sysmex XT 2000i', "comm_type" => 1, "equipment_version" => '', "lab_section" => 1, "feed_source" => 1, "config_file" => '\\BLISInterfaceClient\\configs\\SYSMEX\\SYSMEXXT2000i.xml'),
            array("equipment_name" => 'Vitalex Flexor', "comm_type" => 1, "equipment_version" => '', "lab_section" => 1, "feed_source" => 1, "config_file" => '\\BLISInterfaceClient\\configs\\flexorE\\flexore.xml'),
            );
        foreach ($equipment as $equip)
        {
            BlisClient::create($equip);
        }
        $this->command->info("Blis client table seeded");
        //  interfaced equipment properties
        $props = array(
            array("equip_id" => 1, "prop_id" => 1, "prop_value" => '5150', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 1, "prop_id" => 2, "prop_value" => 'client', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 1, "prop_id" => 3, "prop_value" => 'chameleon', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 1, "prop_id" => 4, "prop_value" => 'yes', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 3, "prop_id" => 5, "prop_value" => '10', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 3, "prop_id" => 6, "prop_value" => '9600', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 3, "prop_id" => 7, "prop_value" => 'None', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 3, "prop_id" => 8, "prop_value" => '1', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 3, "prop_id" => 9, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 3, "prop_id" => 10, "prop_value" => '8', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 3, "prop_id" => 11, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 2, "prop_id" => 12, "prop_value" => 'create ODBC datasource to the equipment db and put name here', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 2, "prop_id" => 13, "prop_value" => '0', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 4, "prop_id" => 5, "prop_value" => '10', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 4, "prop_id" => 6, "prop_value" => '9600', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 4, "prop_id" => 7, "prop_value" => 'None', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 4, "prop_id" => 8, "prop_value" => '1', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 4, "prop_id" => 9, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 4, "prop_id" => 10, "prop_value" => '8', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 4, "prop_id" => 11, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 5, "prop_id" => 1, "prop_value" => '5150', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 5, "prop_id" => 2, "prop_value" => 'server', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 5, "prop_id" => 3, "prop_value" => 'no', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 5, "prop_id" => 4, "prop_value" => 'set the Analyzer PC IP address here', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 6, "prop_id" => 14, "prop_value" => '', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 6, "prop_id" => 15, "prop_value" => '', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 6, "prop_id" => 16, "prop_value" => '', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 6, "prop_id" => 17, "prop_value" => '', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 6, "prop_id" => 18, "prop_value" => '', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 6, "prop_id" => 19, "prop_value" => '', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 7, "prop_id" => 5, "prop_value" => '10', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 7, "prop_id" => 6, "prop_value" => '9600', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 7, "prop_id" => 7, "prop_value" => 'None', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 7, "prop_id" => 8, "prop_value" => '1', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 7, "prop_id" => 9, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 7, "prop_id" => 10, "prop_value" => '8', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 7, "prop_id" => 11, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 8, "prop_id" => 5, "prop_value" => '10', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 8, "prop_id" => 6, "prop_value" => '9600', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 8, "prop_id" => 7, "prop_value" => 'None', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 8, "prop_id" => 8, "prop_value" => '1', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 8, "prop_id" => 9, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 8, "prop_id" => 10, "prop_value" => '8', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 8, "prop_id" => 11, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 9, "prop_id" => 1, "prop_value" => '5150', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 9, "prop_id" => 2, "prop_value" => 'server', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 9, "prop_id" => 3, "prop_value" => 'no', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 9, "prop_id" => 4, "prop_value" => 'set the Analyzer PC IP address here', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 10, "prop_id" => 5, "prop_value" => '10', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 10, "prop_id" => 6, "prop_value" => '9600', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 10, "prop_id" => 7, "prop_value" => 'None', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 10, "prop_id" => 8, "prop_value" => '1', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 10, "prop_id" => 9, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 10, "prop_id" => 10, "prop_value" => '8', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 10, "prop_id" => 11, "prop_value" => 'No', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 11, "prop_id" => 1, "prop_value" => '5150', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 11, "prop_id" => 2, "prop_value" => 'server', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 11, "prop_id" => 3, "prop_value" => 'no', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 11, "prop_id" => 4, "prop_value" => 'set the Analyzer PC IP address here', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 12, "prop_id" => 1, "prop_value" => '5150', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 12, "prop_id" => 2, "prop_value" => 'server', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 12, "prop_id" => 3, "prop_value" => 'no', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            array("equip_id" => 12, "prop_id" => 4, "prop_value" => 'set the Analyzer PC IP address here', "created_at" => date('Y-m-d H:i:s'), "updated_at" => date('Y-m-d H:i:s')),
            );
        foreach ($props as $prop)
        {
            DB::table('equip_config')->insert($prop);
        }
        $this->command->info("Equipment config table seeded");

        /* Require Verifications table */
        RequireVerification::create(["verification_required" => "0", "verification_required_from"=>'6:00 PM', 'verification_required_to' => '6:00 PM']);
        $this->command->info('Require Verifications table seeded');
    }
}