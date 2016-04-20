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
		//$this->call('KBLISSeeder');//for  itech's intitial setup. comment out the rest
		$this->call('TestDataSeeder');
		$this->call('ConfigSettingSeeder');
		// $this->call('CCCSeeder');
	}
}
