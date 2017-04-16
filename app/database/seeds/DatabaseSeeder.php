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
		$this->call('TestDataSeeder');
		$this->call('ConfigSettingSeeder');
		// $this->call('CCCSeeder');
		// $this->call('EditVerifiedSeeder');
	}
}