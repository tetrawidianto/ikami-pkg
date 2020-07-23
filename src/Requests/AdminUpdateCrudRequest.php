<?php

namespace IkamiPkg\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use HaloPkg\Models\Admin;

class AdminUpdateCrudRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userModel = Admin::class;
        $userModel = new $userModel();
        $routeSegmentWithId = empty(config('backpack.base.route_prefix')) ? '2' : '3';

        $userId = $this->get('id') ?? \Request::instance()->segment($routeSegmentWithId);

        if (!$userModel->find($userId)) {
            abort(400, 'Could not find that entry in the database.');
        }

        return [
            'email'    => 'required|unique:admins,email,'.$userId,
            'name'     => 'required',
            'password' => 'confirmed',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
