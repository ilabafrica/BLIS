<?php

use Illuminate\Database\QueryException;

class ControlMeasureController extends \BaseController {
	/**
	 * Save control measures
	 *
	 * @param  input  $measures
	 * @param int control id
	 * @return Response
	 */
	public function save($measures, $controlId)
	{
		foreach ($measures as $measure) {
            $ControlMeasure = new ControlMeasure;
            $ControlMeasure->name = $measure['name'];
            $ControlMeasure->control_measure_type_id = $measure['measure_type_id'];
            $ControlMeasure->expected_value = $measure['expected_value'];
            $ControlMeasure->unit = $measure['unit'];

            try{
                $ControlMeasure->save();
            }catch(QueryException $e){
                Log::error($e);
            }
        }
	}
}