<?php

class MeasureRange extends Eloquent
{
	//	Constants for numeric ranges i.e. Low, Normal, High
	const LOW = 0;
	const NORMAL = 1;
	const HIGH = 2;
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'measure_ranges';

	public $timestamps = false;


	/**
	 * Class constants 
	 *
	 */
	const MALE = 0;
	const FEMALE = 1;
	const BOTH = 2;

	/**
	 * Measure relationship
	 */
	public function measure()
	{
	  return $this->belongsTo('Measure');
	}
	/**
	 * Enabling revisionable
	 *
	 */
	use Venturecraft\Revisionable\RevisionableTrait;

    protected $revisionEnabled = true;

    /**
	 *  Check to if the measure range is revised
	 *
	 * @return boolean
	 */
	public function isRevised()
	{
		if($this->revisionHistory->count() > 0)
			return true;
		else 
			return false;
	}
	/**
	 *  Get referenced range in the list of revised ranges
	 *
	 * @return range
	 */
	public function referencedRange($time_entered = null)
	{
		if($time_entered)
		{
			$history = $this->revisionHistory()->where('created_at', '>=', $time_entered)->orderBy('created_at', 'ASC')->count();
			if($history > 0)
				return $this->revisionHistory()->where('created_at', '>=', $time_entered)->orderBy('created_at', 'ASC')->first();
			else
				return null;
		}
		else
			return null;
	}
}