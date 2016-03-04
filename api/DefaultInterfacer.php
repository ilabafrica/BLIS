<?php namespace Api;

class DefaultInterfacer implements InterfacerInterface {

    /*
    * Get retreives or accepts data from the external system
    */
    public function retrieve($item){
        return true;
    }

    /**
    * Save the received data in the patient, test and specimen tables
    */
    public function process($data){
        return true;
    }

    /**
    * Send the data(flag,results) back to the external system
    */
    public function send($message){
        return true;
    }

}