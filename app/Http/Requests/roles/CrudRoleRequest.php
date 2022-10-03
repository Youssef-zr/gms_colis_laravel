<?php

namespace App\Http\Requests\roles;

use Illuminate\Foundation\Http\FormRequest;

class CrudRoleRequest extends FormRequest
{
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
        $rules = [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ];

        $method = strtolower(request()->method());
        if ($method == "patch") {
            $rules['name'] = 'sometimes|nullable|unique:roles,name,' . $this->role;
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'nom du role',
            'permission' => 'autorisations',
        ];
        return $attributes;
    }
}
