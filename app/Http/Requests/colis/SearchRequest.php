<?php

namespace App\Http\Requests\colis;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
        return [
            'start_date' => 'sometimes|nullable|date|before_or_equal:end_date',
            'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
        ];
    }

    public function attributes()
    {
        return [
            'start_date' => 'Date du',
            'end_date' => 'Date au',
        ];
    }
}
