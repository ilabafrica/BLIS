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
				} catch (\Exception $e) {
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

		$className = "\\KBLIS\\Plugins\\".head(explode(".", last(explode("/", $fileName))));

		// Check if the className is a valid plugin file
		if(class_exists($className)){
			$dummyIP = "10.10.10.1";
			$instrument = new $className($dummyIP);
	
			if(is_subclass_of($instrument, '\\KBLIS\\Instrumentation\\AbstractInstrumentor')){
				$instrument->getEquipmentInfo()['code'];
	        	return trans('messages.success-importing-driver');
			} else {
				Log::error("invalid-driver-file: " . $className);
			}
		}

		if (File::exists($destination.$fileName)) {
			File::delete($destination.$fileName);
		}
    	return trans('messages.invalid-driver-file');
	}

	/**
	 * Get a list of all installed plugins
	 *
	 * @param optional boolean withClassName - Return the class name as well
	 *
	 * @return array('code' => array('name', 'className'))
	 */
	public static function getInstalledPlugins($withClassName = false){

		$plugins = glob(app_path()."/kblis/plugins/*.php");
		$dummyIP = "10.10.10.1";
		$plugs = array();

		foreach ($plugins as $plugin) {
			$className = "\\KBLIS\\Plugins\\".head(explode(".", last(explode("/", $plugin))));

			// Check if its a valid plugin file
			if(class_exists($className)){

				$instrument = new $className($dummyIP);

				if(is_subclass_of($instrument, '\\KBLIS\\Instrumentation\\AbstractInstrumentor')){

					$code = $instrument->getEquipmentInfo()['code'];
					$name = $instrument->getEquipmentInfo()['name'];

					if ($withClassName) {
						$plugs[$code] = array('name' => $name, 'class' => $className);
					}
					else
					{
						$plugs[$code] = $name;
					}
				} else {
					Log::error("invalid-driver-file: " . $className);
				}
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

	/**
	 * Set compatible specimen types
	 *
	 * @param $testType
	 * @return Response json
	 */
	public function fetchResult($testType){

 		// Invoke the Instrument Class to get the results
		$result = (new $this->driver_name($this->ip))->getResult();


		// Change measure names to measure_ids in the returned array
		$resultWithIDs = array();

		foreach ($result as $measureName => $value) {
			$measureFound = $testType->measures->filter(
				function($measure) use ($measureName){
					if($measure->name == $measureName) return $measure;
			});

			if(empty($measureFound->toArray())){
				$resultWithIDs[$measureName] = $value;
			}else{
				$resultWithIDs['m_'.$measureFound->first()->id] = $value;
			}
		}

		// Send back a json result
		return json_encode($resultWithIDs);
	}
	/**
	 * Lots relationship
	 */
	public function lots()
	{
	  return $this->hasMany('Lot');
	}
}