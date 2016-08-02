<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		$this->call('KBLISSeeder');//I-TECH FRESH INSTALL SEEDER
		$this->call('CatalogConfigSeeder');//SEEDER FOR DEFAULT CATALOG CONFIGURATION
		// $this->call('TestDataSeeder');//SEEDER WITH TEST DATA ONLY
		$this->call('ConfigSettingSeeder');//SEEDER FOR NEW CONFIGURATIONS AFTER UPGRADE
		// $this->call('CCCSeeder');

	}
}
