<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateEntregaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check() && Auth::user()->hasPermissionTo('entregas.edit')) {
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
        $rules = [
            'tipo' => [
                'required',
                Rule::in(['p', 'e']),
                'alpha',
            ],
            'franquicia' => [
                'required',
                'integer',
                'exists:franquicias,id',
            ],
            'fecha' => [
                'required',
                'date',
            ],
        ];

        switch ($this->tipo) {
            case 'p':
                $rules = array_merge($rules, [
                    'cliente' => 'integer|required|exists:personas,id',
                ]);
                break;

            case 'e':
                $rules = array_merge($rules, [
                    'cliente' => 'integer|required|exists:empresas,id',
                ]);
                break;
            
            default:
                $rules = array_merge($rules, [
                    'cliente' => 'integer|required',
                ]);
                break;
        }

        return $rules;
    }
}
