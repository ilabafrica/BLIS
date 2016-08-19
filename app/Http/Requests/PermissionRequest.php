<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use App\Models\Permission;
class PermissionRequest extends Request {
	/**
	* Determine if the user is authorized to make this request.
	* This accepts requests of permission to role mapping, the permmissions are created
	* by seeding and is part of the code it is not created on the fly
	* @return bool
	*/
	public function authorize() {
		return true;
	}
	/**
	* Get the validation rules that apply to the request.
	*
	* @return array
	*/
	public function rules() {
		return [];
	}

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        if (($this->ajax() && ! $this->pjax()) || $this->wantsJson()) {
            return new JsonResponse($errors, 422);
        }
        return redirect()->route('permission.index')
			->withInput($this->except($this->dontFlash))
			->withErrors($errors, $this->errorBag);
    }
}
