<?php
/**
 * Tests for SanitasInterfacer class in api folder
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

class MedbossInterfacerTest extends TestCase
{
    public function setup()
    {
        parent::setup();
        $this->app->bind('Interfacer', 'MedbossInterfacer');
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    //Test for a function
    public function testGetDobFromAge()
    {
    	//10 years
    	$dob = Interfacer::getDobFromAge('3652');
    	$this->assertEquals('2005-03-04', $dob);

    	//1 day
    	$dob = Interfacer::getDobFromAge('1');
    	$this->assertEquals('2015-03-03', $dob);

    	//100 days
    	$dob = Interfacer::getDobFromAge('100');
    	$this->assertEquals('2014-11-24', $dob);
    }

    public function testGetFormattedResults()
    {
        $results = Interfacer::getFormattedResults(9);
        $this->assertEquals('BS for mps : +++', $results);
    }
}
