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
            'name' => 'required|string|max:255', // Bắt buộc nhập tên
            'unit' => 'nullable|string|max:100', // Không bắt buộc
            'dosage' => 'nullable|string|max:100', // Không bắt buộc
            'route' => 'nullable|string|max:100', // Không bắt buộc
            'times_per_day' => 'nullable|integer|min:1', // Không bắt buộc nhưng nếu có phải là số nguyên và >= 1
            'note' => 'nullable|string|max:255', // Không bắt buộc
            'price' => 'nullable|integer|min:0', // Thêm 'required' nếu cần thiết

    
        ];
    }
}
