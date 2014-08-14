
<?php

class Specimen extends Eloquent
{
	use SoftDeletingTrait;
    	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'specimens';

	public $timestamps = false;

	/**
	 * Enabling soft deletes for specimen details.
	 *
	 * @var boolean
	 */
	protected $softDelete = true;

	/**
	 * Test Phase relationship
	 */
	public function testPhases()
	{
		return $this->belongsTo('TestPhase');
	}
	
	/**
	 * Specimen Status relationship
	 */
	public function specimenStatuses()
	{
		return $this->belongsTo('SpecimenStatus');
	}
	
	/**
	 * Specimen Type relationship
	 */
	public function specimenTypes()
	{
		return $this->belongsTo('SpecimenType');
	}
	
	/**
	 * Rejection Reason relationship
	 */
	public function rejectionReasons()
	{
		return $this->belongsTo('RejectionReason');
	}
}