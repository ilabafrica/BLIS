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
		// $this->call('KBLISSeeder');
		$this->call('TestDataSeeder');
		$this->call('ConfigSettingSeeder');
		$this->call('CCCSeeder');
	}
}