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
            "numero_commande" => "required|string",
            "code_destinataire" => "required|string",
            "numero_suivi" => "required|string",
            "date" => "sometimes|nullable|date",
            "id_statut" => "sometimes|nullable",
            "nom_destinataire" => "required|string",
            "adresse_destinataire" => "required|string",
            "tel" => "required|string",
            "id_ville" => "required|nullable",
            "id_remarques" => "sometimes|nullable",
            "montant" => 'required',
        ];

        return $rules;
    }
}
