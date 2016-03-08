<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SpecimenTypeRequest;
use App\Models\SpecimenType;
use Response;
use Auth;
use Session;
use Lang;

/**
 * Contains functions for managing specimen types  
 *
 */
class SpecimenTypeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active specimentypes
			$specimentypes = SpecimenType::orderBy('name', 'ASC')->get();

		// Load the view and pass the specimentypes
		return view('specimentype.index', compact('specimentypes'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create SpecimenType
		return view('specimentype.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SpecimenTypeRequest $request)
	{
		$specimentype = new SpecimenType;
		$specimentype->name = $request->name;
		$specimentype->description = $request->description;
		$specimentype->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_specimentype', $specimentype ->id);
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
		$specimentype = SpecimenType::find($id);

		//Show the view and pass the $specimentype to it
		return view('specimentype.show', compact('specimentype'));
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
		$specimentype = SpecimenType::find($id);

		//Open the Edit View and pass to it the $specimentype
		return view('specimentype.edit', compact('specimentype'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SpecimenTypeRequest $request, $id)
	{
		$specimentype = SpecimenType::find($id);
		$specimentype->name = $request->name;
		$specimentype->description = $request->description;
		$specimentype->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-saved'))->with('active_specimentype', $specimentype ->id);
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
		//Soft delete the specimentype
		$specimentype = SpecimenType::find($id);
		$inUseByTesttype = $specimentype->testTypes->toArray();
		$inUseBySpecimen = $specimentype->specimen->toArray();
		if (empty($inUseByTesttype) && empty($inUseBySpecimen)) {
		    // The specimen type is not in use
			$specimentype->delete();
		} else {
		    // The specimen type is in use
		    return view('specimentype.index')->with('message', trans('general-terms.failure-delete-record'));
		}
		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('general-terms.record-successfully-deleted'));
	}
}