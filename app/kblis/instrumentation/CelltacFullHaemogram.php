<?php
namespace KBLIS\Instrumentation;
 
class CelltacFullHaemogram extends AbstractInstrumentor
{   
	/**
	* Fetch Test Result from machine and format it into a JSON string
	*
	* @return Response (JSON)
	*
	*/
    public function getResult() {

    	/*
    	* 1. Read result file stored on the local machine (Use IP/host to verify that I'm on the correct host)
    	* 2. Parse the data
    	* 3. Return an array of key-value pairs: measure_name => value
    	*/

		/*-------------
		* Sample output
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
    	$result = array(
    		"SAMPLE_ID" => "339869",
    		"WBC" => "6.2",
    		"LY%" => "17.8",
    		"MO%" => "74.2",
    		"NE%" => "7.2",
    		"EO%" => "0.7",
    		"BA%" => "0.1",
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

        return json_encode($result);
    }
}