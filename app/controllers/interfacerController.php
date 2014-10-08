<?php

class interfacerController extends \BaseController{

    public function receiveLabrequest()
    {
        //authenticate() connection

        $labRequest = Input::all();
        //Validate::ifValid()

        //Fire event with the received data
        Event::fire('api.receivedLabrequest', array($labRequest));
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