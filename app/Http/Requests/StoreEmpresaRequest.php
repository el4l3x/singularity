<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('empresas.create')) {
            return true;
        } else {
            return false;
        }
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'rif' => 'required|numeric|digits:9|unique:empresas,rif',
            'tipo' => [
                'required',
                'alpha',
                Rule::in(['j', 'g']),
            ],
            'nombre' => 'required',
            'codigo' => 'numeric:digits:4',
            'telefono' => 'numeric|digits:7',
            'estado' => 'required|exists:estados,id|integer',
            'ciudad' => 'required',
            'sector' => 'required',
        ];
    }
}
