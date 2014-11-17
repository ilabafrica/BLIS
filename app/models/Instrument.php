<?php

class Instrument extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'instruments';

	/**
	 * TestType relationship
	 */
	public function testTypes()
	{
	  return $this->belongsToMany('TestType', 'instrument_testtypes');
	}

	/**
	 * Set compatible specimen types
	 *
	 * @return void
	 */
	public function setTestTypes($testTypes){

		$testTypesAdded = array();

		if(is_array($testTypes)){
			foreach ($testTypes as $name) {
				try {
					$testTypesAdded[] = TestType::where('name', '=', $name)->first()->id;
				} catch (Exception $e) {
					Log::error($e);
				}
			}
		}

		if(count($testTypesAdded) > 0){
			// Delete existing instrument test_type mappings
			$this->testTypes()->detach();
			// Add the new mapping
			$this->testTypes()->attach($testTypesAdded);
		}
	}

}