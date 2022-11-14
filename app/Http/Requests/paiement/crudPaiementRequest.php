<?php

namespace App\Http\Requests\paiement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class crudPaiementRequest extends FormRequest
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
            "date" => 'sometimes|nullable|date',
            "heure" => 'sometimes|nullable|string',
            "id_Expediteur" => 'required|string',
            "id_utilisateur" => 'required|string',
            "recu_paiment" => "sometimes|nullable|image|mimes:jpg,png,jpeg,gif,svg",
            "colis" => 'sometimes|nullable|array',
        ];

        $method = strtolower(request()->method());
        if ($method == "patch") {
            $rules = Arr::except($rules, ['id_Expediteur', "id_utilisateur"]);
        }

        return $rules;
    }
}
