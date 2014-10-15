<?php

class MedbossInterfacer implements InterfacerInterface {

    public function retrieve($item)
    {
        //Setup mssql connection
        //query medboss server
        //save received data in staging table
    }

    public function process($data)
    {

    }

    public function send($message)
    {
        //Sends results or any other flag back to where they came from
    }
}