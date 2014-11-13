<?php
namespace KBLIS\Instrumentation;
 
interface InstrumentorInterface
{
	/**
	* Returns test results obtained from an instrument 
	*
	* @return array('name' => '', 'description' => '', 'testTypes' => array()) 
	*/
    public function getEquipmentInfo();

	/**
	* Returns test results obtained from an instrument 
	*
	* @param int testTypeIdentifier
	* @return array('SAMPLE_ID' => id, measureName => measureValue, ...)
	*/
    public function getResult($testTypeID = 0);
}