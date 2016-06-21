<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Role;

class RoleRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = $this->ingnoreId();
		return [
            'name'   => 'required|unique:roles,name,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('role');
		$name = $this->input('name');
		return Role::where(compact('id', 'name'))->exists() ? $id : '';
	}
    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
	// todo: this is not helping much... especially the phpunit test, also because it is failing somewhere I can't tell
    public function response(array $errors)
    {
        if (($this->ajax() && ! $this->pjax()) || $this->wantsJson()) {
            return new JsonResponse($errors, 422);
        }
        return redirect()->back()
			->withInput($this->except($this->dontFlash))
			->withErrors($errors, $this->errorBag);
    }
}