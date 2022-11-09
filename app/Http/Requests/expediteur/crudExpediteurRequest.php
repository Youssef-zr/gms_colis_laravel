<?php

namespace App\Http\Requests\expediteur;

use Illuminate\Foundation\Http\FormRequest;

class crudExpediteurRequest extends FormRequest
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
            'nom' => 'required|string',
            'tel' => 'sometimes|nullable|digits:10',
            'adresse' => 'sometimes|nullable|string',
            'mail' => 'required|email|unique:expediteurs,mail',
        ];

        $method = strToLower(request()->method());
        if ($method == "patch") {
            $rules['mail'] = 'required|email|unique:expediteurs,mail,' . $this->expediteur->id;
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'tel' => 'Téléphone',
            'mail' => 'e-mail',
        ];

        return $attributes;
    }
}
