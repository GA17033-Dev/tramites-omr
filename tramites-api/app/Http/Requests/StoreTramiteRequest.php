<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTramiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo'        => 'required|string|max:50|unique:tramites,codigo',
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'required|string',
            'institucion_id'=> 'required|exists:instituciones,id',
            'dias_habiles'  => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required'         => 'El código es obligatorio',
            'codigo.unique'           => 'El código ya existe',
            'nombre.required'         => 'El nombre es obligatorio',
            'descripcion.required'    => 'La descripción es obligatoria',
            'institucion_id.required' => 'La institución es obligatoria',
            'institucion_id.exists'   => 'La institución no existe',
            'dias_habiles.required'   => 'Los días hábiles son obligatorios',
            'dias_habiles.min'        => 'Los días hábiles deben ser mayor a 0',
        ];
    }


    public function getData(): array
    {
        return $this->only(['codigo', 'nombre', 'descripcion', 'institucion_id', 'dias_habiles']);
    }
}