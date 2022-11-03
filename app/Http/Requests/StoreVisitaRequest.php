<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreVisitaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('visitas.create')) {
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
            'entrada' => 'required',
            'salida' => '',
            'tipo' => [
                'required',
                'alpha',
                Rule::in(['p', 'e']),
            ],
            'cliente' => 'required|integer',
            'productos' => 'array',
            'servicios' => 'array',
        ];
    }
}
