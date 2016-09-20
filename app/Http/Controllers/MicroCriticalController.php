<?php namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Requests\MicroCriticalRequest;
use App\Models\MicroCritical;
use Response;
use Auth;
use Session;
use Lang;

use Illuminate\Database\QueryException;

/**
 * Contains microcriticals resources  
 * 

SupplierRequest $request */

class MicroCriticalController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all microcriticals
		$microcritical = MicroCritical::orderBy('id', 'ASC')->get();
		//Load the view and pass the microcriticals
		return view('microcritical.index')->with('microcritical', $microcritical);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create microcritical
		return view('microcritical.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(MicroCritical $request)
	{
		//store
		$microcritical = new MicroCritical;
		$microcritical->description = $request->description;
		try{
			$microcritical->save();
			$url = session('SOURCE_URL');
        
        	return redirect()->to($url)
				->with('message', trans('messages.record-successfully-saved')) ->with('activemicrocritical', $microcritical ->id);
		}catch(QueryException $e){
			Log::error($e);
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
		//show a microcritical
		$microcritical = MicroCritical::find($id);
		//show the view and pass the $microcritical to it
		return view('microcritical.show')->with('microcritical',$microcritical);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the microcritical
		$microcritical = MicroCritical::find($id);

		//Open the Edit View and pass to it the $microcritical
		return view('microcritical.edit')->with('microcritical', $microcritical);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(MicroCritical $request, $id)
	{
		// Update
		$microcritical = MicroCritical::find($id);
		$microcritical->description = $request->description;
		$microcritical->save();

		// redirect
		$url = session('SOURCE_URL');
        
        return redirect()->to($url)
			->with('message', trans('messages.record-successfully-updated')) ->with('activetestcategory', $microcritical ->id);
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
		//Soft delete the microcritical
		$microcritical = MicroCritical::find($id);

		/*$testCategoryInUse = TestType::where('test_category_id', '=', $id)->first();
		if (empty($testCategoryInUse)) {
		    // The test category is not in use
			$testcategory->delete();
		} else {
		    // The test category is in use
		    $url = session('SOURCE_URL');
            
            return redirect()->to($url)
		    	->with('message', trans('messages.failure-test-category-in-use'));
		}*/
		// redirect
			$url = session('SOURCE_URL');
            
            return redirect()->to($url)
			->with('message', trans('messages.record-successfully-deleted'));
	}
}
