<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ReasonRequest;
use App\Models\RejectionReason;
use Response;
use Auth;
use Session;
use Lang;

/**
 * Contains functions for managing specimen rejection  
 *
 */
class ReasonController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // List all the active rejection reasons
        $rejections = RejectionReason::orderBy('reason', 'ASC')->get();

        // Load the view and pass the reasons
        return view('rejection.index', compact('rejections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create rejection
        return view('rejection.create');
    }

    /**
     * Store a newly created resource in storage.
     * @return Response
     */
    public function store(ReasonRequest $request)
    {
        $rejection = new RejectionReason;
        $rejection->reason = $request->reason;
        $rejection->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_rejection', $rejection ->id);
    }

    /**
     * Show details for the selected record
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Get the Rejection Reason
        $rejection = RejectionReason::find($id);
        //Open the Edit View and pass to it the $rejection
        return view('rejection.show', compact('rejection'));
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
        return view('rejection.edit', compact('rejection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(ReasonRequest $request, $id)
    {
        $rejection = RejectionReason::find($id);
        $rejection->reason = $request->reason;
        $rejection->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_rejection', $rejection ->id);
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
            $url = session('SOURCE_URL');
            
            return redirect()->to($url)->with('message', trans('terms.failure-delete-record'));
        }
        // redirect
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-deleted'));
    }
}