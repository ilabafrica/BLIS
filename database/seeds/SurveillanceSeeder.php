<?php namespace Database\Seeds;

class SurveillanceSeeder extends DatabaseSeeder
{
    public function run()
    {
        //Seed for diseases
        $malaria = Disease::create(array('name' => "Malaria"));
        $typhoid = Disease::create(array('name' => "Typhoid"));
        $dysentry = Disease::create(array('name' => "Shigella Dysentry"));

        $this->command->info("Dieases table seeded");

        $reportDiseases = array(
            array(
                "test_type_id" => 291,//BS for mps
                "disease_id" => $malaria->id,
                ),
             array(
                "test_type_id" => 288,//Salmonella Antigen Test
                "disease_id" => $typhoid->id,
                ),
            array(
                "test_type_id" => 316,//Stool for CS
                "disease_id" => $typhoid->id,
                ),
             array(
                "test_type_id" => 316,//Stool for CS
                "disease_id" => $dysentry->id,
                ),
        );

        foreach ($reportDiseases as $reportDisease) {
            ReportDisease::create($reportDisease);
        }
        $this->command->info("Report Disease table seeded");
    }
}