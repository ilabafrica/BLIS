<?php
use Illuminate\Database\QueryException;

class PanelController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$panels = Panel::orderBy('name', 'asc')->get();	    
		return View::make('panel.index')->with('panels',$panels);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('panel.create');
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'name' => 'required|unique:panel,name',
			 );
		$validator = Validator::make(Input::all(),$rules);

		//Validate from input
		if($validator->fails()){
			return Redirect::route('panel.create')->withErrors($validator);
		}else {
			 // Save the panel
			$newpanel = new Panel();
			$newpanel->name = Input::get('name');
			$newpanel->description = Input::get('description');

			$newpanel->save();

			return Redirect::route('panel.index')->with('message',trans('messages.success-adding-panel'));
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
		$panel = Panel::find($id);
		return View::make('panel.show')->with('panel',$panel);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$panel = Panel::find($id);
		return View::make('panel.edit')->with('panel',$panel);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'name' => 'required',
			);
		$validator = Validator::make(Input::all(),$rules);
		if ($validator->fails()){
			return Redirect::back()->withErrors($validator);
		} else {
			//update
			$panel = Panel::find($id);
			$panel->name = Input::get('name');
			$panel->description  = Input::get('description');
			try{
				$panel->save();
				$message = trans ('messages.success-updating-panel');
			}catch(QueryException $e){
				$message = trans('messages.failure-updating-panel');
				Log::error($e);
			}
			return  Redirect::route('panel.index')->with('message',$message);
		}
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

	public function deactivate($id)
    {
        //panel
		$panel = Panel::find($id);
		$panel->active === 0 ? $panel->active = 1 : $panel->active = 0;
        $panel->save();
		$url = Session::get('SOURCE_URL');
		return Redirect::route('panel.index')->with('message', 'Panel deactivated');
	}
}
