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
        $this->call('Database\Seeds\KBLISMinimalSeed');
        $this->call('Database\Seeds\TestDataSeeder');
        $this->call('Database\Seeds\KBLISSeeder');
        $this->call('Database\Seeds\CultureSensitivitySeeder');
        Model::reguard();
    }
}
