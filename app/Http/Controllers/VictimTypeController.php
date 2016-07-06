<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\VictimTypeRequest;
use App\Models\VictimType;
use Response;
use Auth;
use Session;
use Lang;

/**
 * Contains functions for managing specimen types  
 *
 */
class VictimTypeController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // List all the active victimtypes
        $victimtypes = VictimType::orderBy('name', 'ASC')->get();

        // Load the view and pass the victimtypes
        return view('victimtype.index', compact('victimtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create SpecimenType
        return view('victimtype.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(VictimTypeRequest $request)
    {
        $victimtype = new VictimType;
        $victimtype->name = $request->name;
        $victimtype->description = $request->description;
        $victimtype->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_victimtype', $victimtype ->id);
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
        $victimtype = VictimType::find($id);

        //Show the view and pass the $victimtype to it
        return view('victimtype.show', compact('victimtype'));
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
        $victimtype = VictimType::find($id);

        //Open the Edit View and pass to it the $victimtype
        return view('victimtype.edit', compact('victimtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(VictimTypeRequest $request, $id)
    {
        $victimtype = VictimType::find($id);
        $victimtype->name = $request->name;
        $victimtype->description = $request->description;
        $victimtype->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_victimtype', $victimtype ->id);
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