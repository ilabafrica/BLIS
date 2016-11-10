<?php

class InterfacerController extends \BaseController{

    public function receiveLabRequest()
    {
        //authenticate() connection

        $labRequest = Request::getContent();
        $labRequest = str_replace(['labRequest', '='], ['', ''], $labRequest);

        //Validate::ifValid()

        //Fire event with the received data
        Event::fire('api.receivedLabRequest', json_decode($labRequest));
    }


    /* -------------------------------------------------
    * proposed to do in future, for a full api we need to connect to blis and
    * get a variety of data, for analysis and such.
    * --------------------------------------------------
    */
    public function authenticate(){}
    public function connect(){}
    public function disconnect(){}
    public function searchPatients(){}
    public function searchResults(){}
}