<?php

class RoleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::paginate(Config::get('kblis.page-items'));
		return View::make('role.index')->with('roles', $roles);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('role.create');
	}

	/**
	*	Controller function for making view for assigning roles to users
	*
	*	@return Response
	*/
	Public function assign()
	{
		$users = User::all();
		$roles = Role::all();
		$userRoleData = array('users'=>$users, 'roles'=>$roles);

		return View::make('role.assign', $userRoleData);
	}

	/**
	*	Saving the mapping for user to role assignment
	*
	*	@return Response
	*/
	public function saveUserRoleAssignment()
	{
		$arrayUserRoleMapping = Input::get('userRoles');
		$users = User::all();
		$roles = Role::all();

		foreach ($users as $userkey => $user) {
			foreach ($roles as $roleKey => $role) {
				//If checkbox is clicked attach the role
				if(!empty($arrayUserRoleMapping[$userkey][$roleKey]))
				{
					$user->attachRole($role);
				}
				//If checkbox is NOT clicked detatch the role
				elseif (empty($arrayUserRoleMapping[$userkey][$roleKey])) {
					$user->detachRole($role);
				}
			}
		}
		return Redirect::route('role.assign')->with('message', trans('messages.success-updating-role'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array('name' => 'required|unique:roles|min:3', 'description' => 'max:200');
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::route('role.create')->withInput()->withErrors($validator);
		}
		else
		{
			$role = new Role;
			$role->name = Input::get('name');
			$role->description = Input::get('description');

			try
			{
				$role->save();
				return Redirect::route('role.index')->with('message', trans('messages.success-adding-role'));
			}
			catch (QueryException $e)
			{
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
		//No need for showing
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$role = Role::find($id);
		return View::make('role.edit')->with('role', $role);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array('name' => "required|unique:roles,name,$id|min:3", 'description' => 'max:200');
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails())
		{
			return Redirect::route('role.edit', array($id))->withInput()->withErrors($validator);
		}
		else
		{
			$role = Role::find($id);
			$role->name = Input::get('name');
			$role->description = Input::get('description');

			try
			{
				$role->save();
				return Redirect::route('role.index')->with('message', trans('messages.success-updating-role'));
			}
			catch (QueryException $e)
			{
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
		//Soft delete the role
        $role = Role::find($id);
        $role->delete();
        // redirect
        return Redirect::to('role')->with('message', trans('messages.success-deleting-role'));
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
