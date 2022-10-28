<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StorePersonaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('personas.create')) {
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
            'cedula' => 'required|integer|digits_between:6,8|unique:personas,cedula',
            'nacionalidad' => [
                'required',
                'alpha', 
                Rule::in(['v', 'e']),
            ],
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
