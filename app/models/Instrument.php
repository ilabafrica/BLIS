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

	/**
	 * Save plugin file if its a valid file
	 *
	 * @param file object
	 * @return String success/failure message
	 */
	public static function saveDriver($file){

		$fileName = $file->getClientOriginalName();
        $destination = app_path().'/kblis/plugins/';

        try {
            $file->move($destination, $fileName);
        } catch (Exception $e) {
            Log::error($e);
        	return trans('messages.unwriteable-destination-folder');
        }

		try {
			$className = "KBLIS\\Plugins\\".head(explode(".", last(explode("/", $fileName))));
			if(class_exists($className)){
				$dummyIP = "10.10.10.1";
				$instrument = new $className($dummyIP);
				$plugs[$instrument->getEquipmentInfo()['code']] = $instrument->getEquipmentInfo()['name'];
	        	return trans('messages.driver-imported-successfully');
			}
		} catch (Exception $e) {
			Log::error($e);
		}

		if (File::exists($destination.$fileName)) {
			File::delete($destination.$fileName);
		}
    	return trans('messages.invalid-driver-file');
	}

	/**
	 * Get a list of all installed plugins
	 *
	 * @return array('code' => 'name')
	 */
	public static function getInstalledPlugins(){

		$plugins = glob(app_path()."/kblis/plugins/*.php");
		$dummyIP = "10.10.10.1";
		$plugs = array();

		foreach ($plugins as $plugin) {
			try {
				$className = "KBLIS\\Plugins\\".head(explode(".", last(explode("/", $plugin))));
				if(class_exists($className)){
					$instrument = new $className($dummyIP);
					$plugs[$instrument->getEquipmentInfo()['code']] = $instrument->getEquipmentInfo()['name'];
				}
			} catch (Exception $e) {
				Log::error($e);
			}
		}

		return $plugs;
	}


}