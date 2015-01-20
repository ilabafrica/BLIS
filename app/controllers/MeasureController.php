<?php

use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;

/**
 * Contains measure resources  
 * Measures are standard units and ranges of test results
 */
class MeasureController extends \BaseController {

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
        $rules = array();
        $rules['name'] = 'required|unique:measures,name';
        $rules['measure_type_id'] = 'required|non_zero_key';
        
        switch (Input::get('measure_type_id')) {
            case Measure::NUMERIC:
                $rules['rangemin.0'] = 'required';
                $rules['rangemax.0'] = 'required';
                $rules['agemin.0'] = 'required';
                $rules['agemax.0'] = 'required';
                $rules['gender.0'] = 'required';
                break;
            
            case Measure::ALPHANUMERIC:
                $rules['val.0'] = 'required';
                break;
            
            case Measure::AUTOCOMPLETE:
                $rules['val.0'] = 'required';
                break;
            
            default:
                break;
        }

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::route("measure.create")
                ->withInput(Input::all())
                ->withErrors($validator);
        } else {
            // store
            $measure = new Measure;
            $measure->name = Input::get('name');
            $measure->measure_type_id = Input::get('measure_type_id');
            $measure->unit = Input::get('unit');
            $measure->description = Input::get('description');

            try{
                $measure->save();
            }catch(QueryException $e){
                Log::error($e);
            }
            
            if ($measure->isNumeric()) {
                $val['agemin'] = Input::get('agemin');
                $val['agemax'] = Input::get('agemax');
                $val['gender'] = Input::get('gender');
                $val['rangemin'] = Input::get('rangemin');
                $val['rangemax'] = Input::get('rangemax');
                $val['interpretation'] = Input::get('interpretation');

                // Add ranges for this measure
                for ($i=0; $i < count($val['agemin']); $i++) { 
                    $measurerange = new MeasureRange;
                    $measurerange->measure_id = $measure->id;
                    $measurerange->age_min = $val['agemin'][$i];
                    $measurerange->age_max = $val['agemax'][$i];
                    $measurerange->gender = $val['gender'][$i];
                    $measurerange->range_lower = $val['rangemin'][$i];
                    $measurerange->range_upper = $val['rangemax'][$i];
                    $measurerange->interpretation = $val['interpretation'][$i];
                    $measurerange->save();
                 }
                return Redirect::route('measure.index')
                    ->with('message', trans('messages.success-creating-measure'));
            }else if( $measure->isAlphanumeric() || $measure->isAutocomplete() ) {
                $val['val'] = Input::get('val');
                $val['interpretation'] = Input::get('interpretation');
                for ($i=0; $i < count($val['val']); $i++) { 
                    $measurerange = new MeasureRange;
                    $measurerange->measure_id = $measure->id;
                    $measurerange->alphanumeric = $val['val'][$i];
                    $measurerange->interpretation = $val['interpretation'][$i];
                    $measurerange->save();
                }
            }
            return Redirect::route('measure.index')
                ->with('message', trans('messages.success-creating-measure'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
        $rules = array('name' => 'required');
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // Update
            $measureTypeId = Input::get('measure_type_id');
            $measure = Measure::find($id);
            $measure->name = Input::get('name');
            $measure->measure_type_id = $measureTypeId;
            $measure->unit = Input::get('unit');
            $measure->description = Input::get('description');
            $measure->save();
            if ($measureTypeId != Measure::FREETEXT) {
               
                if ($measureTypeId == Measure::NUMERIC){
                    $val['agemin'] = Input::get('agemin');
                    $val['agemax'] = Input::get('agemax');
                    $val['gender'] = Input::get('gender');
                    $val['rangemin'] = Input::get('rangemin');
                    $val['rangemax'] = Input::get('rangemax');
                }else{
                    $val['val'] = Input::get('val');
                }
                $val['measurerangeid'] = Input::get('measurerangeid');
                $val['interpretation'] = Input::get('interpretation');

                $allRangeIDs = array();

                for ($i=0; $i < count((Input::get('agemin')) ? $val['agemin'] : $val['val']); $i++) {
                    if ($val['measurerangeid'][$i]==0) {
                        $measurerange = new MeasureRange;
                    }else{
                        $measurerange = MeasureRange::find($val['measurerangeid'][$i]);
                    }
                    $measurerange->measure_id = $measure->id;

                    if ($measureTypeId == Measure::NUMERIC){
                        $measurerange->age_min = $val['agemin'][$i];
                        $measurerange->age_max = $val['agemax'][$i];
                        $measurerange->gender = $val['gender'][$i];
                        $measurerange->range_lower = $val['rangemin'][$i];
                        $measurerange->range_upper = $val['rangemax'][$i];
                    }else{
                        $measurerange->alphanumeric = $val['val'][$i];
                    }

                    $measurerange->interpretation = $val['interpretation'][$i];

                    $measurerange->save();

                    $allRangeIDs[] = $measurerange->id;
                 }
             // Delete any pre-existing ranges for this measure_id that were not captured in the above loop.
                $allMeasureRanges = MeasureRange::where('measure_id', '=', $measure->id)->get(array('id'));
                $deleteRanges = array();

                foreach ($allMeasureRanges as $key => $value) {
                    if (!in_array($value->id, $allRangeIDs)) {
                        $deleteRanges[] = $value->id;
                    }
                }
                if(count($deleteRanges)>0)MeasureRange::destroy($deleteRanges);
            }else{
                // Since this id has no ranges, delete any references to this id in the measure_range table
                MeasureRange::where('measure_id', '=', $measure->id)->delete();
            }
            // redirect
            return Redirect::route('measure.index')
                    ->with('message', trans('messages.success-updating-measure'));
        }
    }

    /**
     * Remove the specified resource from storage (soft delete).
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        //Soft delete the measure
        $measure = Measure::find($id);
        $inUseByTesttype = $measure->testTypes->toArray();

        if (empty($inUseByTesttype)) {
            // The measure is not in use
            $measure->delete();
        } else {
            // The measure is in use
            return Redirect::route('measure.index')
                ->with('message', trans('messages.failure-test-measure-in-use'));
        }
        // redirect
        return Redirect::route('measure.index')
            ->with('message', trans('messages.success-deleting-measure'));
    }
}