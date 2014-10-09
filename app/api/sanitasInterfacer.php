<?php

class sanitasInterfacer implements interfacerInterface{

    public function get($item)
    {
        // saved received data in staging table
        dd(array());
    }

    public function send($message)
    {
        //Sends results or any other flag back to where they came from
    }
}