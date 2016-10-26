<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Blood extends Eloquent
{
	/**
	 * Enabling soft deletes for blood bank.
	 *
	 */
	use SoftDeletingTrait;
	protected $dates = ['deleted_at'];
    	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'blood_bank';

	/* constants for blood groups */
	const ONEGATIVE = 0;
	const OPOSITIVE = 1;
	const ANEGATIVE = 2;
	const APOSITIVE = 3;
	const BNEGATIVE = 4;
	const BPOSITIVE = 5;
	const ABNEGATIVE = 6;
	const ABPOSITIVE = 7;

	/* Return readable blood group */
	public function bldgrp($grp)
	{
		if($grp == Blood::ONEGATIVE)
			return 'O-';
		else if($grp == Blood::OPOSITIVE)
			return 'O+';
		else if($grp == Blood::ANEGATIVE)
			return 'A-';
		else if($grp == Blood::APOSITIVE)
			return 'A+';
		else if($grp == Blood::BNEGATIVE)
			return 'B-';
		else if($grp == Blood::BPOSITIVE)
			return 'B+';
		else if($grp == Blood::ABNEGATIVE)
			return 'O-';
		else if($grp == Blood::ABPOSITIVE)
			return 'AB+';
	}
}