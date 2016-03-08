<?php namespace App\Http\Controllers;

use Illuminate\Database\QueryException;

use Validator;
use Input;
use Session;
use App\Models\RejectionReason;

/**
 * Contains functions for managing specimen rejection  
 *
 */
class SpecimenRejectionController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // List all the active rejection reasons
        $rejection = RejectionReason::orderBy('reason', 'ASC')->get();

        // Load the view and pass the reasons
        return view('specimenrejection.index')->with('rejection', $rejection);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create rejection
        return view('specimenrejection.create');
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store()
    {
        $rules = array('reason'=> 'required');

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect()->to("specimenrejection.create")
                ->withErrors($validator);
        } else {
            // store
            $rejection = new RejectionReason;
            $rejection->reason = Input::get('reason');
            $rejection->save();
        }
            $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
            
            ->with('message', trans('messages.success-creating-rejection-reason'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the Rejection Reason
        $rejection = RejectionReason::find($id);
        //Open the Edit View and pass to it the $rejection
        return view('specimenrejection.edit')->with('reason', $rejection);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $rules = array('reason' => 'required');

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            // Update
            $rejection = RejectionReason::find($id);
            $rejection->reason = Input::get('reason');
            $rejection->save();

            // redirect
            $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
                    ->with('message', trans('messages.success-updating-rejection-reason')) ->with('activerejection', $rejection->id);
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
        //Soft delete the rejection
        $rejection = RejectionReason::find($id);
        $inUseBySpecimen = $rejection->specimen->toArray();
        try {
            // The rejection is not in use
            $rejection->delete();
        } catch (Exception $e) {
            // The rejection is in use
            $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
                ->with('message', trans('messages.failure-specimen-rejection-reason-in-use'));
        }
        // redirect
            $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
            ->with('message', trans('messages.success-deleting-rejection-reason'));
    }
}