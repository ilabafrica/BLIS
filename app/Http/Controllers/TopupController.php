<?php namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Topup;
use App\Models\TestCategory;
use Auth;

class TopupController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$requests = Topup::all();
		return view('inventory.request.index')->with('requests', $requests);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$items = Item::lists('name', 'id');
		$testCategories = TestCategory::lists('name', 'id');
		return view('inventory.request.create')
			->with('testCategories', $testCategories)
			->with('items', $items);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TopupRequest $request)
	{
		// store
		$topup = new Topup;
		$topup->item_id = $request->item_id;
		$topup->quantity_remaining = $request->quantity_remaining;
		$topup->test_category_id = $request->test_category_id;
		$topup->tests_done = $request->tests_done;
		$topup->quantity_ordered = $request->quantity_ordered;
		$topup->remarks = $request->remarks;
		$topup->user_id = Auth::user()->id;
		try{
			$topup->save();
			$url = session('SOURCE_URL');
        
        	return redirect()->to($url)
				->with('message', trans('messages.record-successfully-saved')) ->with('activerequest', $topup ->id);
		}catch(QueryException $e){
			\Log::error($e);
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
		//show a request
		$request =Topup::find($id);
		//show the view and pass the $request to it
		return view('inventory.request.show')->with('request', $request);
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$request = Topup::find($id);
		$items = Item::lists('name', 'id');
		$item = $request->item_id;
		$testCategories = TestCategory::lists('name', 'id');
		$testCategory = $request->test_category_id;
		return view('inventory.request.edit')
			->with('testCategories', $testCategories)
			->with('items', $items)
			->with('item', $item)
			->with('request', $request)
			->with('testCategory', $testCategory);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(TopupRequest $request, $id)
	{
		// Update
		$topup = Topup::find($id);
		$topup->item_id = $request->item_id;
		$topup->quantity_remaining = $request->quantity_remaining;
		$topup->test_category_id = $request->test_category_id;
		$topup->tests_done = $request->tests_done;
		$topup->quantity_ordered = $request->quantity_ordered;
		$topup->remarks = $request->remarks;
		$topup->user_id = Auth::user()->id;
		try
		{
			$topup->save();
			$url = session('SOURCE_URL');
        
        	return redirect()->to($url)
				->with('message', trans('messages.record-successfully-updated')) ->with('activerequest', $topup ->id);
		}catch(QueryException $e){
			\Log::error($e);
		}
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the request
		$request = Topup::find($id);
		if(count($request->usage)>0)
		{
			return redirect()->to('request.index')->with('message', trans('messages.failure-delete-record'));
		}
		else
		{
			$request->delete();
			// redirect
			return redirect()->to('request.index')->with('message', trans('messages.record-successfully-deleted'));
		}
	}
}
