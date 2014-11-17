<?php
class MeasureTypeSeed extends KBLISSeeder
{
	public static function get()
	{
		return array(
            array("id" => "1", "name" => "Numeric Range"),
            array("id" => "2", "name" => "Alphanumeric Values"),
            array("id" => "3", "name" => "Autocomplete"),
            array("id" => "4", "name" => "Free Text")
		);
	}
}