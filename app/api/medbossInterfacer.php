<?php

class medbossInterfacer implements interfacerInterface {

    public function get($item)
    {
        //Setup mssql connection
        //query medboss server
        //save received data in staging table
    }

    public function send($message)
    {
        //Sends results or any other flag back to where they came from
    }
}