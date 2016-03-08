<?php namespace App\Http\Controllers;

use App\Models\ControlMeasure;
use App\Models\ControlMeasureRange;
class ControlMeasureController extends Controller {

	/**
	 * Save control measures and the ranges
	 *
	 * @param  input  $measures
	 * @param int control id
	 * @return Response
	 */
	public function saveMeasuresRanges($measures, $control)
	{
		foreach ($measures as $measure) {
            $controlMeasure = new ControlMeasure;
            $controlMeasure->name = $measure['name'];
            $controlMeasure->control_measure_type_id = $measure['measure_type_id'];
            $controlMeasure->unit = $measure['unit'];

            DB::transaction(function() use ($controlMeasure, $measure, $control) {
                //If the control has Soft delete control measures
                if (count($control->controlMeasures)) {
                    foreach ($control->controlMeasures as $key => $ctrlMeasures) {
                        //If the measure has ranges Soft delete them
                        if (count($ctrlMeasures->controlMeasureRanges)) {
                            foreach ($ctrlMeasures->controlMeasureRanges as $key => $ctrlMRange) {
                                $ctrlMRange->delete();
                            }
                        }
                    }
                }

                $control->save();
                $controlMeasure->control_id = $control->id;
                $controlMeasure->save();

                if ($controlMeasure->isNumeric()) {
                    // Add ranges for this measure
                    for ($i=0; $i < count($measure['rangemin']); $i++) { 
                        $controlMeasureRange = new ControlMeasureRange;
                        $controlMeasureRange->lower_range = $measure['rangemin'][$i];
                        $controlMeasureRange->upper_range = $measure['rangemax'][$i];
                        $controlMeasureRange->control_measure_id = $controlMeasure->id;
                        $controlMeasureRange->save();
                     }
                }else if( $controlMeasure->isAlphanumeric() ) {
                    for ($i=0; $i < count($measure['val']); $i++) { 
                        $controlMeasureRange = new ControlMeasureRange;
                        $controlMeasureRange->alphanumeric = $measure['val'][$i];
                        $controlMeasureRange->control_measure_id = $controlMeasure->id;
                        $controlMeasureRange->save();
                    }
                }
            });
        }
	}

    /**
     * Edit control measures and the ranges
     *
     * @param  input  $measures
     * @param int control id
     * @return Response
     */
    public function editMeasuresRanges($measures, $control)
    {
        foreach ($measures as $measure) {
            $controlMeasure = ControlMeasure::find($measure['id']);
            $controlMeasure->name = $measure['name'];
            $controlMeasure->control_measure_type_id = $measure['measure_type_id'];
            $controlMeasure->expected_result = $measure['expected'];
            $controlMeasure->unit = $measure['unit'];

            DB::transaction(function() use ($controlMeasure, $measure, $control) {
                foreach ($control->controlMeasures as $key => $ctrlMeasures) {
                    //If the measure has ranges Soft delete them
                    if (count($ctrlMeasures->controlMeasureRanges)) {
                        foreach ($ctrlMeasures->controlMeasureRanges as $key => $ctrlMRange) {
                            $ctrlMRange->delete();
                        }
                    }
                }

                $controlMeasure->control_id = $control->id;
                $controlMeasure->save();

                if ($controlMeasure->isNumeric()) {
                    // Add ranges for this measure
                    for ($i=0; $i < count($measure['rangemin']); $i++) { 
                        $controlMeasureRange = new ControlMeasureRange;
                        $controlMeasureRange->lower_range = $measure['rangemin'][$i];
                        $controlMeasureRange->upper_range = $measure['rangemax'][$i];
                        $controlMeasureRange->control_measure_id = $controlMeasure->id;
                        $controlMeasureRange->save();
                     }
                }else if( $controlMeasure->isAlphanumeric() ) {
                    for ($i=0; $i < count($measure['val']); $i++) { 
                        $controlMeasureRange = new ControlMeasureRange;
                        $controlMeasureRange->alphanumeric = $measure['val'][$i];
                        $controlMeasureRange->control_measure_id = $controlMeasure->id;
                        $controlMeasureRange->save();
                    }
                }
            });
        }
    }
}