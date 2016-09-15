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
        $this->call(Database\Seeds\TestDataSeeder::class);
        $this->call(Database\Seeds\ConfigSettingSeeder::class);
        Model::reguard();
    }
}


