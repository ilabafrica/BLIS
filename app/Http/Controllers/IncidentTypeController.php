<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\IncidentTypeRequest;
use App\Models\IncidentType
use Response;
use Auth;
use Session;
use Lang;

/**
 * Contains functions for managing specimen types  
 *
 */
class IncidentTypeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // List all the active incidenttypes
        $incidenttypes = IncidentType::orderBy('name', 'ASC')->get();

        // Load the view and pass the incidenttypes
        return view('incidenttype.index', compact('incidenttypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create SpecimenType
        return view('incidenttype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(IncidentTypeRequest $request)
    {
        $incidenttype = new IncidentType;
        $incidenttype->name = $request->name;
        $incidenttype->description = $request->description;
        $incidenttype->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_incidenttype', $incidenttype ->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Show a specimentype
        $incidenttype = IncidentType::find($id);

        //Show the view and pass the $incidenttype to it
        return view('incidenttype.show', compact('incidenttype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the specimentype
        $incidenttype = IncidentType::find($id);

        //Open the Edit View and pass to it the $incidenttype
        return view('incidenttype.edit', compact('incidenttype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(IncidentTypeRequest $request, $id)
    {
        $incidenttype = IncidentType::find($id);
        $incidenttype->name = $request->name;
        $incidenttype->description = $request->description;
        $incidenttype->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_incidenttype', $incidenttype ->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage (soft delete).
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        
    }
}