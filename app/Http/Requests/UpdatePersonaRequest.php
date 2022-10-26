<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('personas.edit')) {
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
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'numeric|digits:7',
            'code' => 'numeric|digits:4',
            'estado' => 'required|exists:estados,id|integer',
            'ciudad' => 'required',
            'sector' => 'required',
        ];
    }
}
