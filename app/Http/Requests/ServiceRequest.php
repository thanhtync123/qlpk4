<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $id = $this->segment(3); // Lấy ID từ URL (nếu ID nằm ở vị trí thứ 3 trong đường dẫn)


        return [
            'name' => 'required|unique:services,name,' . $id,
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|in:X-quang,Điện tim,Xét nghiệm,Siêu âm',
            'content' => 'nullable|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên dịch vụ không được để trống.',
            'name.string' => 'Tên dịch vụ phải là chuỗi ký tự.',
            'name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'price.required' => 'Giá dịch vụ không được để trống.',
            'name.unique' => 'Tên dịch vụ này đã tồn tại, vui lòng nhập tên khác.',
            'price.numeric' => 'Giá dịch vụ phải là số.',
            'price.min' => 'Giá dịch vụ không được nhỏ hơn 0.',
            'type.required' => 'Loại dịch vụ không được để trống.',
            'type.string' => 'Loại dịch vụ phải là chuỗi ký tự.',
            'type.in' => 'Loại dịch vụ phải là một trong các giá trị: X-quang, Điện tim, Xét nghiệm.',
        ];
    }
}
