<?php
class SpecimenStatusSeed extends KBLISSeeder
{
	public static function get()
	{
		return array(
          array("id" => "1", "name" => "specimen-not-collected"),
          array("id" => "2", "name" => "specimen-accepted"),
          array("id" => "3", "name" => "specimen-rejected")
		);
	}
}