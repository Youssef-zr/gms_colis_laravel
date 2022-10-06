<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class crudPaymentRequest extends FormRequest
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
            "date" => 'required|date',
            "heure" => 'required|string',
            "id_expediteur" => 'required|string',
            "id_livreur" => 'required|string',
            "recu_paiment" => "sometimes|nullable|image|mimes:jpg,png,jpeg,gif,svg|dimensions:min_width=100,min_height=100,max_width=350,max_height=350|max:150",
            "colis" => 'required|array',
        ];

        return $rules;
    }
}
