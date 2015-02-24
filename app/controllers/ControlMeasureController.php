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
	public function saveMeasures($measures, $controlId)
	{
		foreach ($measures as $measure) {
            $controlMeasure = new ControlMeasure;
            $controlMeasure->name = $measure['name'];
            $controlMeasure->control_measure_type_id = $measure['measure_type_id'];
            $controlMeasure->expected_result = $measure['expected'];
            $controlMeasure->unit = $measure['unit'];
            $controlMeasure->control_id = $controlId;
            $controlMeasure->save();
        }
	}

	/**
	 * Save control measures ranges
	 *
	 * @param input  $measures
	 * @param int control measureID
	 * @param int lotId
	 * @return Response
	 */
	public function saveRanges($ranges, $lotId)
	{
		foreach ($ranges as $range) {
            $controlMeasureRange = new ControlMeasureRange;
            $controlMeasureRange->lower_range = isset($range['rangemin']) ? $range['rangemin'] : null;
            $controlMeasureRange->upper_range = isset($range['rangemax']) ? $range['rangemax'] : null;
            $controlMeasureRange->alphanumeric = isset($range['val']) ? $range['val'] : null ;
            $controlMeasureRange->control_measure_id = $range['control-measure-id'];
            $controlMeasureRange->lot_id = $lotId;
            $controlMeasureRange->save();
        }
	}
}