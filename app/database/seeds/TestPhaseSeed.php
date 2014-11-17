<?php
class TestPhaseSeed extends KBLISSeeder
{
	public static function get()
	{
		return array(
          array("id" => "1", "name" => "Pre-Analytical"),
          array("id" => "2", "name" => "Analytical"),
          array("id" => "3", "name" => "Post-Analytical")
		);
	}
}