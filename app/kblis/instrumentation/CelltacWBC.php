<?php
namespace KBLIS\Instrumentation;
 
class CelltacWBC extends AbstractInstrumentor
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
    		"Lym" => "17.8L",
    		"Mon" => "74.2*",
    		"Neu" => "7.2*",
    		"Eos" => "0.7",
    		"Baso" => "0.1"
	    	);

        return json_encode($result);
    }
}