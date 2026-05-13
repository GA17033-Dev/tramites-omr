<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitucionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'tipo'   => 'required|in:MINISTERIO,ALCALDIA,AUTONOMA',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.max'      => 'El nombre no puede superar los 255 caracteres',
            'tipo.required'   => 'El tipo es obligatorio',
            'tipo.in'         => 'El tipo debe ser MINISTERIO, ALCALDIA o AUTONOMA',
        ];
    }

    public function getData(): array
    {
        return $this->only(['nombre', 'tipo']);
    }

    


}