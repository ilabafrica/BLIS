<?php
namespace KBLIS\Plugins;
 
class CelltacFMachine extends \KBLIS\Instrumentation\AbstractInstrumentor
{   
	/**
	* Returns information about an instrument 
	*
	* @return array('name' => '', 'description' => '', 'testTypes' => array()) 
	*/
    public function getEquipmentInfo(){
    	return array(
    		'code' => 'CF8222', 
    		'name' => 'Celltac F Mek 8222', 
    		'description' => 'Automatic analyzer with 22 parameters and WBC 5 part diff Hematology Analyzer',
    		'testTypes' => array("Full Haemogram", "WBC")
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
		*--------------
		339869         
		 6.2  
		17.8L 
		74.2* 
		 7.2* 
		 0.7  
		 0.1  
		 1.1L 
		 4.7* 
		 0.4* 
		 0.0  
		 0.0  
		4.26  
		10.5L 
		35.5L 
		83.3  
		24.6L 
		29.6L 
		13.0  
		  35L 
		0.02L 
		 7.0  
		21.3H 
		*/

		/*------------------
		* 22 Test Parameters
		*-------------------
		* WBC, LY%, MO%, NE%, EO%, BA%, LY, MO, NE, EO, BA, RBC, HGB, HCT, MCV, MCH, MCHC, RDW, PLT, PCT, MPV, PDW
		*/
		switch ($testTypeID) {
			case 1:
		    	$result = array(
		    		"SAMPLE_ID" => "339869",
		    		"WBC" => "6.2",
		    		"Lym" => "17.8",
		    		"Mon" => "74.2",
		    		"Neu" => "7.2",
		    		"Eos" => "0.7",
		    		"Baso" => "0.1"
			    	);
				break;
			default:
		    	$result = array(
		    		"SAMPLE_ID" => "339869",
		    		"WBC" => "6.2",
		    		"Lym" => "17.8",
		    		"Mon" => "74.2",
		    		"Neu" => "7.2",
		    		"Eos" => "0.7",
		    		"Baso" => "0.1",
		    		"LY" => "1.1",
			    	"MO" => "4.7",
			    	"NE" => "0.4",
			    	"EO" => "0.0",
			    	"BA" => "0.0",
			    	"RBC" => "4.26",
			    	"HGB" => "10.5",
			    	"HCT" => "35.5",
			    	"MCV" => "83.3",
			    	"MCH" => "24.6",
			    	"MCHC" => "29.6",
			    	"RDW" => "13.0",
			    	"PLT" => "35",
			    	"PCT" => "0.02",
			    	"MPV" => "7.0",
			    	"PDW" => "21.3"
			    	);
				break;
		}

        return $result;
    }
}