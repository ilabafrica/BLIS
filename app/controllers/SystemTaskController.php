<?php
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class SystemTaskController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all facilities
		$tasks = SystemTask::orderBy('name', 'asc')->get();
		//Load the view and pass the facilities
		return View::make('systemtask.index')->with('tasks',$tasks);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('systemtask.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validation
		$rules = array('name' => 'required'
			);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::route('systemtask.index')->withErrors($validator)->withInput();
		} else {
			// Add
			$systemtask = new SystemTask;
			$systemtask->name = Input::get('name');
			$systemtask->command = Input::get('command');
			$systemtask->script_location = Input::get('script_location');
			$systemtask->intervals = Input::get('interval');
			// redirect
			try{
				$systemtask->save();

				//Update the crontabs
				$this->updateCron();
				$url = Session::get('SOURCE_URL');
				return Redirect::to('/systemtask')
					->with('message', "The task has been added");
			} catch(QueryException $e){
				Log::error($e);
			}
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
		//Get the facility
		$task = SystemTask::find($id);
		return View::make('systemtask.edit')->with('task', $task);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//Validate and check
		$rules = array('name' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::route('systemtask.index')->withErrors($validator)->withInput();
		} else {
			// Add
			$systemtask =  SystemTask::find($id);
			$systemtask->name = Input::get('name');
			$systemtask->command = Input::get('command');
			$systemtask->script_location = Input::get('script_location');
			$systemtask->intervals = Input::get('intervals');
			// redirect
			try{
				$systemtask->save();
				//Update the crontabs
				$this->updateCron();
				$url = Session::get('SOURCE_URL');
				return Redirect::to('/systemtask')
					->with('message', "The task has been updated");
			} catch(QueryException $e){
				Log::error($e);
			}
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
		//Deleting the Item
		$task = SystemTask::find($id);

		//Soft delete
		$task->delete();
		//Update the crontabs
		$this->updateCron();
		// redirect
		$url = Session::get('SOURCE_URL');
			
			return Redirect::to('/systemtask')

			->with('message', "The tasks has been removed");
	}

	//Function to update crontabs
	
	 function updateCron(){

	 	//Fetch the available System tasks
	 	$systemtask=SystemTask::all();
	 	
	 	//Clear the cron tabs
	 	$process1 = new Process('crontab -r');
		$process1->run();
		
		echo $process1->getOutput();

	 	//Create a string with the system tasks and command
	 	foreach ($systemtask as $task) {
	 		if ($task->intervals>=0 && $task->intervals<=59) {
	 			$crontab="";
	 			$crontab.="\"".$task->intervals;
	 			$crontab.=" 0";
	 			$crontab.=" *";
	 			$crontab.=" *";
	 			$crontab.=" *";
	 			$crontab.=" ".$task->command." ".$task->script_location."\"\n";

	 			$process2 = new Process("(crontab -l ; echo $crontab) | crontab -");
				$process2->run();

				// executes after the command finishes
				if (!$process2->isSuccessful()) {
				    throw new ProcessFailedException($process2);
				}
	 		}
	 		
	 	}
	 	

	}
	//Executes cron on demand
	public function execute($id){
		$task=SystemTask::find($id);
		$crontab="";
		$crontab.="\"".$task->intervals;
		$crontab.=" 0";
		$crontab.=" *";
		$crontab.=" *";
		$crontab.=" *";
		$crontab.=" ".$task->command." ".$task->script_location."\"\n";

		$process2 = new Process("cron $crontab");
		$process2->run();

		// executes after the command finishes
		if (!$process2->isSuccessful()) {
		    throw new ProcessFailedException($process2);
		}

		return Redirect::to('/systemtask')
					->with('message', "The task has been executed");
	}
}
