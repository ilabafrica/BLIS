<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Response;
use Auth;
use Session;
use Lang;

class PermissionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$permissions = Permission::all();
		$roles = Role::all();
		$permissionsRolesData = array('permissions' => $permissions,'roles' => $roles,);
		return view('permission.index', $permissionsRolesData);
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
	public function store(PermissionRequest $request)
	{

		$arrayPermissionRoleMapping = $request->permissionRoles;
		$permissions = Permission::all();
		$roles = Role::all();

		$url = session('SOURCE_URL');

		foreach ($permissions as $permissionkey => $permission) {
			foreach ($roles as $roleKey => $role) {
				//If checkbox is clicked attach the permission
				if(!empty($arrayPermissionRoleMapping[$permissionkey][$roleKey]))
				{
					// check that this permission has not already been attached to a role before attempting it again! 
					if (!$role->perms->find($permission->id)) {
						$role->attachPermission($permission);
					}
				}
				//If checkbox is NOT clicked detatch the permission
				elseif (empty($arrayPermissionRoleMapping[$permissionkey][$roleKey])) {
					$role->detachPermission($permission);
				}
			}
		}

		return redirect()->to($url)->with('message', trans_choice('messages.record-successfully-saved', 1))->with('active_permission', $permission ->id);
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