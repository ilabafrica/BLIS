<?php

class SusceptibilityController extends \BaseController {

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
		$user_id = Auth::user()->id;
		$test = Input::get('test');
		$organism = Input::get('organism');
		$drug = Input::get('drug');
		$zone = Input::get('zone');
		$interpretation = Input::get('interpretation');

		/*Requested variables*/
		//print_r(count(array_values ($test)));
		for($i=0; $i<count($test); $i++){
			$exists[$i] = Susceptibility::where('test_id', $test[$i])
										->where('organism_id', $organism[$i])
										->where('drug_id', $drug[$i])
										->get();
			if($exists[$i]){
				$drugSusceptibility = Susceptibility::find($exists[$i]->id);
				$drugSusceptibility->user_id = $user_id;
				$drugSusceptibility->test_id = $test[$i];
				$drugSusceptibility->organism_id = $organism[$i];
				$drugSusceptibility->drug_id = $drug[$i];
				$drugSusceptibility->zone = $zone[$i];
				$drugSusceptibility->interpretation = $interpretation[$i];
				$drugSusceptibility->save();
				return json_encode($drugSusceptibility);
			}else{
				$drugSusceptibility = new Susceptibility;
				$drugSusceptibility->user_id = $user_id;
				$drugSusceptibility->test_id = $test[$i];
				$drugSusceptibility->organism_id = $organism[$i];
				$drugSusceptibility->drug_id = $drug[$i];
				$drugSusceptibility->zone = $zone[$i];
				$drugSusceptibility->interpretation = $interpretation[$i];
				$drugSusceptibility->save();
				return 0;
			}
			
		}
		if ($action == "results"){
			$test_id = Input::get('testId');
			$organism_id = Input::get('organismId');
			$susceptibility = Susceptibility::where('test_id', $test_id)
											->where('organism_id', $organism_id)
											->get();
			foreach ($susceptibility as $drugSusceptibility) {
				$drugSusceptibility->drugName = Drug::find($drugSusceptibility->drug_id)->name;
				$drugSusceptibility->pathogen = Organism::find($drugSusceptibility->organism_id)->name;
			}

			return json_encode($susceptibility);
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
