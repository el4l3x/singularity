<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEmpresaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('empresas.edit')) {
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
            'nombre' => 'required|unique:empresas,nombre,'.$this->empresa->id,
            'codigo' => 'numeric:digits:4',
            'telefono' => 'numeric|digits:7',
            'estado' => 'required|exists:estados,id|integer',
            'ciudad' => 'required',
            'sector' => 'required',
        ];
    }
}
