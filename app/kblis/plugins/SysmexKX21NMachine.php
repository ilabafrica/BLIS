<?php
namespace KBLIS\Plugins;
 
class SysmexKX21NMachine extends \KBLIS\Instrumentation\AbstractInstrumentor
{
	/**
	* Returns information about an instrument 
	*
	* @return array('name' => '', 'description' => '', 'testTypes' => array()) 
	*/
    public function getEquipmentInfo(){
    	return array(
    		'code' => 'KX21', 
    		'name' => 'Sysmex KX 21', 
    		'description' => 'Automatic analyzer with 22 parameters and WBC 5 part diff Hematology Analyzer',
    		'testTypes' => array("BS for mps")
    		);
    }

	/**
	* Fetch Test Result from machine and format it as an array
	*
	* @return array
	*/
    public function getResult($testTypeID = 0) {

    	/*
    	* 1. Read result file stored on the local machine (Use IP/host to verify that I'm on the correct host)
    	* 2. Parse the data
    	* 3. Return an array of key-value pairs: measure_name => value
    	*/

		/*-------------
		* Sample file output
		*339869 6.2  17.8L 74.2*  7.2*  0.7   0.1   1.1L  4.7*  0.4*  0.0   0.0  4.26  10.5L 35.5L 83.3  24.6L 29.6L 13.0    35L 0.02L  7.0  21.3H */

		/*------------------
		* 22 Test Parameters
		*-------------------
		* WBC, LY%, MO%, NE%, EO%, BA%, LY, MO, NE, EO, BA, RBC, HGB, HCT, MCV, MCH, MCHC, RDW, PLT, PCT, MPV, PDW
		*/

		#
		#   Get results output, sanitize the output,
		#   insert results into an array for handling in front end
		#

		$DUMP_URL = "http://".$this->ip."/celtac/sysmex.dump";

		$RESULTS_STRING = file_get_contents($DUMP_URL);
			if ($RESULTS_STRING === FALSE){
			print "Something went wrong with getting the File";
		};

		if (strlen($RESULTS_STRING) < 120) {
			print "Results file is empty, please press print on celltac machine";
			return;
		}

		$results = array();
		foreach ($RESULTS_STRING as $key => $RESULT) {
			$res = explode("=", $RESULT);
			$results[$res[0]] = $res[1];
		}

		return $results;
	}
}