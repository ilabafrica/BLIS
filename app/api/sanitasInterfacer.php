<?php

class sanitasInterfacer implements interfacerInterface {

    public function get($item)
    {
        //Register route
        //Create event when route is hit by sanitas
        //Event saves received data in staging table and Sends received to load 
    }

    public function send($message)
    {
        //Sends results or any other flag back to where they came from
    }
}