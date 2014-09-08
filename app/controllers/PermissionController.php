<?php

class PermissionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$permissions = Permission::paginate(Config::get('kblis.page-items'));
		$roles = Role::all();
		$permissionRole = PermissionRole::all();
		$permissionsRolesData = array(
			'permissions' => $permissions, 
			'roles' => $roles, 
			'permissionRole' => $permissionRole );

		return View::make('permission.index', $permissionsRolesData);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Permissions are created via code
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
			'name' => 'required|min:4|unique:permissions',
			'description' => 'required'
			);
		$validator = Validator::make(Input::all, $rules);

		if($validator->fails())
		{
			Redirect::Route('permissions.create')->withErrors($validator)->withInput();
		}
		else
		{
			//Save the details
			$permission = new Permission;
			
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
