<?php
namespace KBLIS\Instrumentation;
 
class CelltacFullHaemogram extends AbstractInstrumentor
{   
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
    	$result[] = array("SAMPLE_ID", "339869");
    	$result[] = array("WBC", "6.2");
    	$result[] = array("LY%", "17.8L");
    	$result[] = array("MO%", "74.2*");
    	$result[] = array("NE%", "7.2*");
    	$result[] = array("EO%", "0.7");
    	$result[] = array("BA%", "0.1");
    	$result[] = array("LY", "1.1L");
    	$result[] = array("MO", "4.7*");
    	$result[] = array("NE", "0.4*");
    	$result[] = array("EO", "0.0");
    	$result[] = array("BA", "0.0");
    	$result[] = array("RBC", "4.26");
    	$result[] = array("HGB", "10.5L");
    	$result[] = array("HCT", "35.5L");
    	$result[] = array("MCV", "83.3");
    	$result[] = array("MCH", "24.6L");
    	$result[] = array("MCHC", "29.6L");
    	$result[] = array("RDW", "13.0");
    	$result[] = array("PLT", "35L");
    	$result[] = array("PCT", "0.02L");
    	$result[] = array("MPV", "7.0");
    	$result[] = array("PDW", "21.3H");

        return $result;
    }
}