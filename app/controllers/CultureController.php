<?php

class CultureController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$action = Input::get('action');
		$workUp = new Culture;
		$workUp->user_id = Input::get('userId');
		$workUp->test_id = Input::get('testId');
		$workUp->observation = Input::get('obs');
		if($action == 'add'){
			$workUp->save();
			return 0;
		}
		else if($action == 'draw'){
			$obsv = Test::find($workUp->test_id)->culture;

			foreach ($obsv as $observation) {
				$observation->user = User::find($observation->user_id)->name;
				$observation->timeStamp = Culture::showTimeAgo($observation->created_at);
			}
			return json_encode($obsv);
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
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
}
