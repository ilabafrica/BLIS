<?php
namespace KBLIS\Instrumentation;
 
interface InstrumentorInterface
{
	/*
	* Returns test results obtained from an instrument 
	*/
    public function getResult();
}