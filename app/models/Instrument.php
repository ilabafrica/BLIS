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
	 * @param optional boolean withClassName
	 *
	 * @return array('code' => array('name', 'className'))
	 */
	public static function getInstalledPlugins($withClassName = false){

		$plugins = glob(app_path()."/kblis/plugins/*.php");
		$dummyIP = "10.10.10.1";
		$plugs = array();

		foreach ($plugins as $plugin) {
			try {
				$className = "KBLIS\\Plugins\\".head(explode(".", last(explode("/", $plugin))));

				if(class_exists($className)){

					$instrument = new $className($dummyIP);

					$code = $instrument->getEquipmentInfo()['code'];
					$name = $instrument->getEquipmentInfo()['name'];

					if ($withClassName) {
						$plugs[$code] = array('name' => $name, 'class' => $className);
					}
					else
					{
						$plugs[$code] = $name;
					}
				}
			} catch (Exception $e) {
				Log::error($e);
			}
		}

		return $plugs;
	}

	/**
	 * Save instrument
	 *
	 * @param String machineCode, String ip, optional String hostname
	 * @return String success/failure message
	 */
	public static function saveInstrument($code, $ip, $hostname = ""){

		$plugin = Instrument::getInstalledPlugins(true);
		$className = "";

		// Get the class name of the user selected plugin
		foreach ($plugin as $key => $plug) {
			// If the instrument_code matches that of the select box, WE HAVE A MATCH
			if($key == $code){
				$className = $plug['class'];
				break;	
			}
		}

		if (class_exists($className)) {
			$instrument = new $className($ip);

			$deviceInfo = $instrument->getEquipmentInfo();

			$newInstrument = new Instrument();
			$newInstrument->name = $deviceInfo['name'];
			$newInstrument->description = $deviceInfo['description'];
			$newInstrument->driver_name = $className;
			$newInstrument->ip = $ip;
			$newInstrument->hostname = Input::get('hostname');

			try{
				$newInstrument->save();
				$newInstrument->setTestTypes($deviceInfo['testTypes']);
				return trans('messages.success-creating-instrument');
			}catch(QueryException $e){
				Log::error($e);
			}
		}

		return trans('messages.failure-creating-instrument');
	}
}