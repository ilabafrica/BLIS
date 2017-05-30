<?php

class CustomFieldSeeder extends Seeder
{
	public function run()
	{
		Eloquent::unguard();

		$customFieldTypes = array(
			array("id" => "1", "name" => "Numeric"),
			array("id" => "4", "name" => "Free Text")
		);

		foreach ($customFieldTypes as $customFieldType)
		{
			CustomFieldType::create($customFieldType);
		}
	}
}