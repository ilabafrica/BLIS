<?php namespace App\Http\Controllers;

use Event;
use Request;
use App\Api\InterfacerInterface;

class InterfacerController extends Controller{

    public function receiveLabRequest()
    {
        // todo: ->retrieve, counts for nothing... let it count
        app(InterfacerInterface::class);
        // Event::fire('api.receivedLabRequest', json_decode($labRequest));
    }


    /** -------------------------------------------------
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