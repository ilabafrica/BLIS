<?php namespace App\Http\Controllers;

use Event;
use Request;
use App\Api\Facades\Interfacer;
// use App\Api\InterfacerInterface;

class InterfacerController extends Controller{

    public function receiveLabRequest()
    {
        //authenticate() connection
        $labRequest = Request::getContent();

        if (is_string($labRequest)) {
            $labRequest = json_decode($labRequest);
        }

        if (is_array($labRequest)) {
            $labRequest = $labRequest[0];
        }

        if (strpos($labRequest,'=') !== false && strpos($labRequest,'labRequest')  !== false) {
            $labRequest = str_replace(['labRequest', '='], ['', ''], $labRequest);
            $labRequest = json_decode($labRequest);
        }

        //Validate::ifValid()
        Interfacer::retrieve($labRequest);
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