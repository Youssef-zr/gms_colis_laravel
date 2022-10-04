<?php

namespace App\Http\Requests\bandel;

use Illuminate\Foundation\Http\FormRequest;

class crudBandleRequest extends FormRequest
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
            "id_expediteur" => "sometimes|nullable",
            "numero_commande" => "required|alpha_num|unique:colis,numero_commande",
            "code_destinataire" => "required|string",
            "numero_suivi" => "required|alpha_num|unique:colis,numero_suivi",
            "date" => "sometimes|nullable|date",
            "id_statut" => "sometimes|nullable",
            "nom_destinataire" => "required|string",
            "adresse_destinataire" => "required|string",
            "tel" => "required|string",
            "id_ville" => "required|nullable",
            "id_remarques" => "sometimes|nullable",
            "montant" => 'required|numeric',
        ];

        $method = strtolower(request()->method());
        if ($method == "patch") {
            $rules["numero_commande"] = "required|numeric|unique:colis,numero_commande," . $this->bundel->id;
            $rules["numero_suivi"] = "required|numeric|unique:colis,numero_suivi," . $this->bundel->id;
        }
        return $rules;

    }
}
