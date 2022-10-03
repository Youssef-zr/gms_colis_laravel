<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;

class EditProfileRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,' . $this->user,
            'phone' => 'required|nullable|numeric|digits:10|unique:users,phone,' . $this->user,
            'photo' => "sometimes|nullable|image|mimes:jpg,png,jpeg,gif,svg|dimensions:min_width=60,min_height=60,max_width=300,max_height=300|max:150",
        ];

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'nom',
            'phone' => 'téléphone',
        ];

        return $attributes;
    }
}
