<?php

class CountyController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all counties
		$subCounties = County::all();
		
		return View::make('county.index', compact('subCounties'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//	Get all counties for select list
		$countries = Country::lists('name', 'id');

		return View::make('county.create', compact('countries'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$subCounty = new County;
        $subCounty->name =Input::get('name');
        $subCounty->country_id = Input::get('country_id');
        $subCounty->user_id = Auth::user()->id;;
        $subCounty->save();

       
        $url = Session::get('SOURCE_URL');
			
			return Redirect::to($url)

			->with('message', 'County created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a subCounty
		$subCounty = SubCounty::find($id);
		//show the view and pass the $subCounty to it
		return view('mfl.subCounty.show', compact('subCounty'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get subCounty
		$subCounty = SubCounty::find($id);
		//	Get all counties
		$counties = County::lists('name', 'id');
		//	Get initially selected county
		$county = $subCounty->county_id;

        return view('mfl.subCounty.edit', compact('subCounty', 'counties', 'county'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SubCountyRequest $request, $id)
	{
		$subCounty = SubCounty::findOrFail($id);;
        $subCounty->name = $request->name;
        $subCounty->county_id = $request->county_id;
        $subCounty->user_id = Auth::user()->id;;
        $subCounty->save();

        return redirect('subCounty')->with('message', 'Sub-County updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$subCounty= SubCounty::find($id);
		$subCounty->delete();
		return redirect('subCounty')->with('message', 'Sub-County deleted successfully.');
	}

	public function destroy($id)
	{
		//
	}	
	/**
	*	Function to return facilities of a particular sub-county to fill facilities dropdown
	*/
	public function dropdown()
	{
		$input = Input::get('sub_county_id');
        $sub_county = SubCounty::find($input);
        $facilities = $sub_county->facilities;
        return json_encode($facilities);
    }
}