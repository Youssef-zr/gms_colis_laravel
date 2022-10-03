<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class crudUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'password' => 'required|same:confirm-password',
            'status' => 'required',
        ];

        $method = strToLower(request()->method());
        if ($method == "patch") {
            $rules['password'] = 'sometimes|nullable';
            $rules['email'] = 'required|email|unique:users,email,' . $this->user;
            $rules['phone'] = 'required|nullable|numeric|digits:10|unique:users,phone,' . $this->user;
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'nom',
            'email' => 'adresse email',
            'phone' => 'téléphone',
            'password' => 'mot de passe',
            'confirm-password' => 'confirmation',
            'status' => 'statut',
        ];

        return $attributes;
    }
}
