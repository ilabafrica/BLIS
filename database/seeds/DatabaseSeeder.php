<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(Database\Seeds\BlisProductionSeeder::class);
        $this->call(Database\Seeds\BlisDevelopmentSeeder::class);
        Model::reguard();
    }
}