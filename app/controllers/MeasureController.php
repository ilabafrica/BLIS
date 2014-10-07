<?php

use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;

/**
 * Contains measure resources  
 * Measures are standard units and ranges of test results
 */
class MeasureController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // List all the active measures
        $measures = Measure::paginate(Config::get('kblis.page-items'));

        // Load the view and pass the measures
        return View::make('measure.index')->with('measures', $measures);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $measuretype = MeasureType::all()->sortBy('id')->lists('name','id');

        //Create measure
        return View::make('measure.create')->with('measuretype', $measuretype);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
        $rules = array('name'=> 'required|unique:measures,name');
        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::route("measure.create")->withErrors($validator)->withInput(Input::except('password'));
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
            
            if ($measure->measure_type_id == 1) {
                $val['agemin'] = Input::get('agemin');
                $val['agemax'] = Input::get('agemax');
                $val['gender'] = Input::get('gender');
                $val['rangemin'] = Input::get('rangemin');
                $val['rangemax'] = Input::get('rangemax');

                // Add ranges for this measure
                for ($i=0; $i < count($val['agemin']); $i++) { 
                    $measurerange = new MeasureRange;
                    $measurerange->measure_id = $measure->id;
                    $measurerange->age_min = $val['agemin'][$i];
                    $measurerange->age_max = $val['agemax'][$i];
                    $measurerange->gender = $val['gender'][$i];
                    $measurerange->range_lower = $val['rangemin'][$i];
                    $measurerange->range_upper = $val['rangemax'][$i];
                    $measurerange->save();
                 }
                return Redirect::route('measure.index')->with('message', 'Successfully created measure!');
            }else if (Input::get('measure_type_id') == 2 || Input::get('measure_type_id') == 3) {
                $values = Input::get('val');
                $measure->measure_range = join('/', $values);
                $measure->save();
                return Redirect::route('measure.index')->with('message', 'Successfully created measure!');
            }
            return Redirect::route("measure.create")->with('message', 'Error occured while creating measure!');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Show a measure
        $measure = Measure::find($id);

        //Show the view and pass the $measure to it
        return View::make('measure.show')->with('measure', $measure);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the measure
        $measure = Measure::find($id);

        $measuretype = MeasureType::all()->sortBy('id')->lists('name','id');

        //Open the Edit View and pass to it the $measure
        return View::make('measure.edit')
                        ->with('measure', $measure)
                        ->with('measuretype', $measuretype);
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
            return Redirect::back()->withErrors($validator)->withInput(Input::except('password'));
        } else {
            // Update
            $measure = Measure::find($id);
            $measure->name = Input::get('name');
            $measure->measure_type_id = Input::get('measure_type_id');
            $measure->unit = Input::get('unit');
            $measure->measure_range = "";
            if (Input::get('measure_type_id') == 2 || Input::get('measure_type_id') == 3) {
                $values = Input::get('val');
                $measure->measure_range = join('/', $values);
            }
            $measure->description = Input::get('description');
            $measure->save();

            if ($measure->measure_type_id == 1) {
                $val['agemin'] = Input::get('agemin');
                $val['agemax'] = Input::get('agemax');
                $val['gender'] = Input::get('gender');
                $val['rangemin'] = Input::get('rangemin');
                $val['rangemax'] = Input::get('rangemax');
                $val['measurerangeid'] = Input::get('measurerangeid');

                $allRangeIDs = array();

                for ($i=0; $i < count($val['agemin']); $i++) {
                    if ($val['measurerangeid'][$i]==0) {
                        $measurerange = new MeasureRange;
                    }else{
                        $measurerange = MeasureRange::find($val['measurerangeid'][$i]);
                    }

                    $measurerange->measure_id = $measure->id;
                    $measurerange->age_min = $val['agemin'][$i];
                    $measurerange->age_max = $val['agemax'][$i];
                    $measurerange->gender = $val['gender'][$i];
                    $measurerange->range_lower = $val['rangemin'][$i];
                    $measurerange->range_upper = $val['rangemax'][$i];

                    $measurerange->save();

                    $allRangeIDs[] = $measurerange->id;
                 }
             // Delete any pre-existing ranges for this measure_id that were not captured in the above loop.
                $allMeasureRanges = MeasureRange::where('measure_id', '=', $measure->id)->get(array('id'));
                $deleteRanges = array();

                foreach ($allMeasureRanges as $key => $value) {
                    if (!in_array($value->id, $allRangeIDs)) {
                        $deleteRanges[] = $value->id;
                        Log::info($value->id);
                    }
                }
                if(count($deleteRanges)>0)MeasureRange::destroy($deleteRanges);
            }else{
                // Since its not a numeric range, delete any references to this id in the measure_range table
                MeasureRange::where('measure_id', '=', $measure->id)->delete();
            }


            // redirect
            return Redirect::route('measure.index')
                    ->with('message', 'The measure details were successfully updated!');
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
        $measure->delete();

        // redirect
        return Redirect::route('measure.index')->with('message', 'The measure was successfully deleted!');
    }

}