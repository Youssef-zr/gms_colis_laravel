<?php

namespace App\Http\Requests\paiement;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Symfony\Component\VarDumper\VarDumper;

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
            "id_expediteur" => 'required|string',
            "id_livreur" => 'required|string',
            "recu_paiment" => "sometimes|nullable|image|mimes:jpg,png,jpeg,gif,svg",
            "colis" => 'sometimes|nullable|array',
        ];

        $method = strtolower(request()->method());
        if ($method == "patch") {
            $rules = Arr::except($rules,['id_livreur',"id_expediteur"]);
        }

        return $rules;
    }
}
