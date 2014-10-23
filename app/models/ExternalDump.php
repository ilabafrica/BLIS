<?php

class ExternalDump extends Eloquent {
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'external_dump';

    protected $fillable = array('labNo', 'parentLabNo', 'test_id', 'requestingClinician', 'investigation',
    	'provisional_diagnosis', 'requestDate', 'orderStage', 'result', 'result_returned',
    	'patientVisitNumber', 'patient_id', 'fullName', 'dateOfBirth', 'gender', 'address', 'postalCode',
    	'phoneNumber', 'city', 'cost', 'receiptNumber', 'receiptType', 'waiver_no', 'system_id');

    const TEST_NOT_FOUND = 0;

}