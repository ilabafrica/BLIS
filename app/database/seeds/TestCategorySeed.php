<?php

class TestCategorySeed extends KBLISSeeder
{
	public static function get()
	{
		return array(
			array('id' => '1', 'name' => 'SEROLOGY'),
			array('id' => '2', 'name' => 'HAEMATOLOGY'),
			array('id' => '3', 'name' => 'MCH'),
			array('id' => '4', 'name' => 'VIROLOGY'),
			array('id' => '5', 'name' => 'HISTOLOGY AND CYTOLOGY'),
			array('id' => '6', 'name' => 'BIOCHEMISTRY'),
			array('id' => '7', 'name' => 'MICROBIOLOGY'),
			array('id' => '8', 'name' => 'OTHER'),
			array('id' => '9', 'name' => 'CLINICAL CHEMISTRY'),
			array('id' => '10', 'name' => 'BACTERIOLOGY'),
			array('id' => '12', 'name' => 'PARASITOLOGY'),
			array('id' => '13', 'name' => 'BLOOD TRANSFUSION'),
			array('id' => '14', 'name' => 'Test Section')
		);
	}
}
