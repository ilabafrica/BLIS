<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\OrganismRequest;

use App\Models\Organism;
use App\Models\Drug;

use Response;
use Auth;
use Session;
use Lang;

class OrganismController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all organisms
		$organisms = Organism::orderBy('name', 'ASC')->get();
		//Load the view and pass the organisms
		return view('organism.index')->with('organisms',$organisms);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$drugs = Drug::orderBy('name')->get();
		//Create organism
		return view('organism.create')->with('drugs', $drugs);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(OrganismRequest $request)
	{
		$organism = new Organism;
		$organism->name = $request->name;
		$organism->description = $request->description;
		$organism->save();
		if($request->drugs){
			$organism->setDrugs($request->drugs);
		}
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_organism', $organism ->id);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a organism
		$organism = Organism::find($id);
		//show the view and pass the $organism to it
		return view('organism.show')->with('organism',$organism);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$drugs = Drug::orderBy('name')->get();
		//Get the organism
		$organism = Organism::find($id);

		//Open the Edit View and pass to it the $organism
		return view('organism.edit')
					->with('organism', $organism)
					->with('drugs', $drugs);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(OrganismRequest $request, $id)
	{
		$organism = Organism::find($id);
		$organism->name = $request->name;
		$organism->description = $request->description;
		$organism->save();
		if($request->drugs){
			$organism->setDrugs($request->drugs);
		}
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_organism', $organism ->id);
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
		//Soft delete the organism
		$organism = Organism::find($id);

		/*$testCategoryInUse = TestType::where('test_category_id', '=', $id)->first();
		if (empty($testCategoryInUse)) {
		    // The test category is not in use
			$testcategory->delete();
		} else {
		    // The test category is in use
		    $url = Session::get('SOURCE_URL');
            
            return Redirect::to($url)
		    	->with('message', trans('messages.failure-test-category-in-use'));
		}*/
		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}