<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng sử dụng request này
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Nam,Nữ',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên bệnh nhân.',
            'name.string' => 'Tên bệnh nhân phải là chuỗi ký tự.',
            'name.max' => 'Tên bệnh nhân không được quá 255 ký tự.',

            'date_of_birth.required' => 'Vui lòng nhập ngày sinh.',
            'date_of_birth.date' => 'Ngày sinh không hợp lệ.',

            'gender.required' => 'Vui lòng chọn giới tính.',
            'gender.in' => 'Giới tính chỉ có thể là Nam hoặc Nữ.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại chỉ được chứa số.',

            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được quá 255 ký tự.',
        ];
    }
}
