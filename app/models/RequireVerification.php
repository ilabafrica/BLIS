<?php

class RequireVerification extends Eloquent
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'require_verifications';

	public $timestamps = false;

	// Check whether unverified results may be sent to EMR
	public function allowProbativeResults()
	{
		// If verification required
		if ($this->verification_required == 1) {

			$timeNow = new DateTime('now');
			if ($this->verification_required_from == $this->verification_required_to) {
				// If the time prohibits sending probative results
				return false;
			}elseif ($timeNow->format('H:i:s') > $this->verification_required_from &&
					$timeNow->format('H:i:s') < $this->verification_required_to) {
				// If the time prohibits sending probative results
				return false;
			}else{
				// If the time permits sending probative results
				return true;
			}
		}else{
			return true;
		}
	}

}