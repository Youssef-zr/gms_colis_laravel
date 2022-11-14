<?php

namespace App\Http\Requests\colis;

use App\Models\Colis;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class crudColisRequest extends FormRequest
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
            "id_Expediteur" => "required|nullable",
            "numero_commande" => "required|string|unique:colis,numero_commande",
            // "code_destinataire" => "sometimes|nullable|string",
            "numero_suvi" => "sometimes|nullable|alpha_num|unique:colis,numero_suvi",
            "date" => "sometimes|nullable|date",
            "id_statut" => "sometimes|nullable",
            "nom_destinataire" => "required|string",
            "adresse_destinataire" => "required|string",
            "tel" => "required|string",
            "id_ville" => "required|nullable",
            "id_remarques" => "sometimes|nullable",
            "montant" => 'required|numeric',
            "type_paiement" => 'sometimes|nullable',
        ];

        $method = strtolower(request()->method());
        if ($method == "patch") {
            $rules["numero_commande"] = ["sometimes","nullable", "string", Rule::unique("colis","numero_commande")->ignore($this->coli->id_colis,"id_colis")];
            $rules["numero_suvi"] = ["required", "alpha_num",  Rule::unique("colis","numero_suvi")->ignore($this->coli->id_colis,"id_colis")];
        }

        return $rules;
    }
}
