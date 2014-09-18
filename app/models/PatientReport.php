<?php
class PatientReport extends Eloquent{
	public function getTurnaroundTime()
	{
		$startTime = new DateTime($this->time_started);
		$endTime = new DateTime($this->time_completed);
		$interval = $startTime->diff($endTime);

		$turnaroundTime = ($interval->days * 24 * 3600) + ($interval->h * 3600) + ($interval->i * 60) + ($interval->s);
		return $turnaroundTime;
	}
	
}