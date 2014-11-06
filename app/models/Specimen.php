<?php

class Specimen extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'specimens';

	public $timestamps = false;

	/**
	 * Specimen status constants
	 */
	const NOT_COLLECTED = 1;
	const ACCEPTED = 2;
	const REJECTED = 3;
	/**
	 * Enabling soft deletes for specimen details.
	 *
	 * @var boolean
	 */
	// protected $softDelete = true;//it wants deleted at fills,

	/**
	 * Test Phase relationship
	 */
	public function testPhase()
	{
		return $this->belongsTo('TestPhase');
	}
	
	/**
	 * Specimen Status relationship
	 */
	public function specimenStatus()
	{
		return $this->belongsTo('SpecimenStatus');
	}
	
	/**
	 * Specimen Type relationship
	 */
	public function specimenType()
	{
		return $this->belongsTo('SpecimenType');
	}
	
	/**
	 * Rejection Reason relationship
	 */
	public function rejectionReason()
	{
		return $this->belongsTo('RejectionReason');
	}

	/**
	 * Test relationship
	 */
	public function test()
    {
        return $this->hasOne('Test');
    }

    /**
	 * referrals relationship
	 */
	public function refferal()
    {
        return $this->hasOne('Referral');
    }

    /**
	 * Specimen verified
	 *
	 * @return boolean
	 */
    public function isReferred()
    {
    	if($this->refferal()->isEmpty())
    	{
    		return false;
    	}
    	else 
    		return true;
    }
}