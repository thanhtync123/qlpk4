<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;  // Cho phép tất cả người dùng
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:100',
            'dosage' => 'required|string|max:100',
            'route' => 'required|string|max:100',
        ];
    }
}
