<?php namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Models\Item;
use Response;
use Session;
use Auth;
use Lang;

class ItemController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//	Get all items
		$items = Item::all();
		return view('item.index', compact('items'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('item.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ItemRequest $request)
	{
		$item = new Item;
        $item->name = $request->name;
        $item->unit = $request->unit;
        $item->remarks = $request->remarks;
        $item->min_level = $request->min_level;
        $item->max_level = $request->max_level;
        $item->user_id = 1;
        $item->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-saved'))->with('active_item', $item ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//show a item
		$item = Item::find($id);
		//show the view and pass the $item to it
		return view('item.show', compact('item'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//	Get item
		$item = Item::find($id);

        return view('item.edit', compact('item'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ItemRequest $request, $id)
	{
		$item = Item::findOrFail($id);
		$item->name = $request->name;
        $item->unit = $request->unit;
        $item->remarks = $request->remarks;
        $item->min_level = $request->min_level;
        $item->max_level = $request->max_level;
        $item->user_id = 1;
        $item->save();
        
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-updated'))->with('active_item', $item ->id);
	}	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the item
		$item = Item::find($id);
		$item->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', trans('messages.record-successfully-deleted'));
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
	 * generate barcode
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function barcode($id)
	{
		//Get the specific item
		$item = Item::find($id);
		//show the view and pass the $item to it
		return DNS1D::getBarcodeHTML($item->id, "CODABAR");
	}
}
