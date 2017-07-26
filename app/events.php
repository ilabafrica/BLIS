<?php

// Display all SQL executed in Eloquent
Event::listen('illuminate.query', function($query)
{
        // Log::info($query);
});

Event::listen('test.saved', function($testId)
{
	Interfacer::send($testId);
});

Event::listen('test.verified', function($testId)
{
	Interfacer::send($testId);
});
//TO DO: move events to app/events.php or somewhere else
Event::listen('api.receivedLabRequest', function($labRequest)
{
    //We instruct the interfacer to handle the request
    Interfacer::retrieve($labRequest);
});
