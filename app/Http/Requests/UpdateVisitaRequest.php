<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateVisitaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('visitas.edit')) {
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
            'productos' => 'array',
            'servicios' => 'array',
        ];
    }
}
