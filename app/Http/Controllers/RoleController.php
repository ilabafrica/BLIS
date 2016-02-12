<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\RoleRequest;

use App\Models\Role;
use App\Models\User;

use Config;
use Response;
use Auth;
use Session;
use Lang;

class RoleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$roles = Role::paginate(Config::get('kblis.page-items'));
		return view('role.index')->with('roles', $roles);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('role.create');
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

		return view('role.assign', $userRoleData);
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

		$url = session('SOURCE_URL');
		return reditect()->to($url)->with('message', trans('messages.success-updating-role'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RoleRequest $request)
	{
		$role = new Role;
		$role->name = $request->name;
		$role->description = $request->description;
		$role->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_role', $role ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$role = Role::find($id);
		return view('role.show', compact('role'));
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
		return view('role.edit', compact('role'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RoleRequest $request, $id)
	{
		$role = Role::find($id);
		$role->name = $request->name;
		$role->description = $request->description;
		$role->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_role', $role ->id);
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
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
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