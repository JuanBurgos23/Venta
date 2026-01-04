<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductosRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'items' => ['required','array','min:1'],
            'items.*.codigo' => ['required'],
            'items.*.nombre' => ['required','string','max:200'],

            'items.*.descripcion' => ['nullable','string'],
            'items.*.marca' => ['nullable','string','max:100'],
            'items.*.modelo' => ['nullable','string','max:100'],
            'items.*.origen' => ['nullable','string','max:100'],
            'items.*.precio' => ['nullable','numeric','min:0'],

            // Los siguientes llegan como texto y se mapean a IDs en el controlador:
            'items.*.unidad' => ['nullable','string','max:100'],
            'items.*.tipo_producto' => ['nullable','string','max:150'],
            'items.*.categoria' => ['nullable','string','max:150'],
            'items.*.subcategoria' => ['nullable','string','max:150'],
            'items.*.tipo_precio' => ['nullable','string','max:150'],
            'items.*.proveedor' => ['nullable','string','max:200'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'No se recibieron productos.',
            'items.*.codigo.required' => 'El campo CÓDIGO es obligatorio.',
            'items.*.nombre.required' => 'El campo NOMBRE es obligatorio.',
        ];
    }
}
