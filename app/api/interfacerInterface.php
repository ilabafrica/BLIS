<?php

interface interfacerInterface {
    /*
    | Interface for the BLIS api.
    |
    | see http://en.wikipedia.org/wiki/Extract,_transform,_load for the idea behind this.
    */

    /*
    * Get retreives or accepts data from the external system
    */
    public function retrieve($item);

    /**
    * Save the received data in the patient, test and specimen tables
    */
    public function process($data);

    /**
    * Send the data(flag,results) back to the external system
    */
    public function send($message);
}
