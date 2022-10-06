<?php

namespace App\Http\Requests\bundel;

use Illuminate\Foundation\Http\FormRequest;

class recuSignatureRequest extends FormRequest
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
            'signature' => 'sometimes|nullable',
            'receipt' => "sometimes|nullable|image|mimes:jpg,png,jpeg,gif,svg|dimensions:min_width=100,min_height=100,max_width=350,max_height=350|max:150",
        ];

        return $rules;
    }
}
