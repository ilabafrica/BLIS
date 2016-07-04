<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\DrugRequest;
use App\Models\Drug;
use Response;
use Auth;
use Session;
use Lang;
/**
 * Contains drugs resources  
 * 
 */
class DrugController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all drugs
		$drugs = Drug::orderBy('name', 'ASC')->get();
		//Load the view and pass the drugs
		return view('drug.index', compact('drugs'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create drug
		return view('drug.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(DrugRequest $request)
	{
		// dd('we in');
		$drug = new Drug;
		$drug->name = $request->name;
		$drug->description = $request->description;
		$drug->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_drug', $drug ->id);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a drug
		$drug = Drug::find($id);
		//show the view and pass the $drug to it
		return view('drug.show', compact('drug'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the drug
		$drug = Drug::find($id);

		//Open the Edit View and pass to it the $drug
		return view('drug.edit', compact('drug'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(DrugRequest $request, $id)
	{
		$drug = Drug::find($id);
		$drug->name = $request->name;
		$drug->description = $request->description;
		$drug->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_drug', $drug ->id);
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
		//Soft delete the drug
		$drug = Drug::find($id);

		/*$testCategoryInUse = TestType::where('test_category_id', '=', $id)->first();
		if (empty($testCategoryInUse)) {
		    // The test category is not in use
			$testcategory->delete();
		} else {
		    // The test category is in use
		    $url = session('SOURCE_URL');
            
            return Redirect::to($url)
		    	->with('message', trans('terms.failure-test-category-in-use'));
		}*/
		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-deleted'));
	}
}
