<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnoses;

class DiagnoseController extends Controller
{
    // Hiển thị danh sách chẩn đoán
    public function index()
    {
        $diagnoses = Diagnoses::all();
        return view('diagnose.index', compact('diagnoses'));
    }

    // Thêm chẩn đoán
    public function store(Request $request)
    {
        // Kiểm tra tên chẩn đoán đã tồn tại chưa
        $request->validate([
            'name' => 'required|string|max:255|unique:diagnoses,name',
        ], [
            'name.unique' => 'Tên chẩn đoán đã tồn tại, vui lòng nhập tên khác.',
            'name.required' => 'Tên chẩn đoán không được để trống.',
            'name.max' => 'Tên chẩn đoán không được vượt quá 255 ký tự.'
        ]);

        // Thêm mới chẩn đoán
        Diagnoses::create([
            'name' => $request->name,
        ]);

        return redirect()->route('diagnose.index')->with('success', 'Chẩn đoán đã được thêm thành công!');
    }

    // Sửa chẩn đoán
    public function edit($id)
    {
        $diagnose = Diagnoses::findOrFail($id);
        return view('diagnose.edit', compact('diagnose'));
    }

    // Cập nhật chẩn đoán
    public function update(Request $request, $id)
    {
        // Kiểm tra tên chẩn đoán đã tồn tại chưa, ngoại trừ chẩn đoán hiện tại
        $request->validate([
            'name' => 'required|string|max:255|unique:diagnoses,name,' . $id,
        ], [
            'name.unique' => 'Tên chẩn đoán đã tồn tại, vui lòng nhập tên khác.',
            'name.required' => 'Tên chẩn đoán không được để trống.',
            'name.max' => 'Tên chẩn đoán không được vượt quá 255 ký tự.'
        ]);

        $diagnose = Diagnoses::findOrFail($id);
        $diagnose->update([
            'name' => $request->name,
        ]);

        return redirect()->route('diagnose.index')->with('success', 'Chẩn đoán đã được cập nhật thành công!');
    }

    // Xóa chẩn đoán
    public function destroy($id)
    {
        $diagnose = Diagnoses::findOrFail($id);
        $diagnose->delete();

        return redirect()->route('diagnose.index')->with('success', 'Chẩn đoán đã được xóa thành công!');
    }
}
