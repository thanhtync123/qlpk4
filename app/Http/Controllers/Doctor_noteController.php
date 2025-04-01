<?php

namespace App\Http\Controllers;

use App\Models\Doctor_notes;
use Illuminate\Http\Request;

class Doctor_noteController extends Controller
{
    public function index()
    {
        $doctorNotes = Doctor_notes::paginate(10);  // Giả sử bạn muốn phân trang
        return view('doctor_note.index', compact('doctorNotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            // Thêm các validation khác nếu cần
        ]);

        Doctor_notes::create($request->all());

        return redirect()->route('doctor_note.index')->with('success', 'Thêm lời dặn thành công!');
    }

    public function edit($id)
    {
        $doctorNote = Doctor_notes::findOrFail($id);
        return view('doctor_note.edit', compact('doctorNote'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',

        ]);

        $Doctor_notes = Doctor_notes::findOrFail($id);
        $Doctor_notes->update($request->all());

        return redirect()->route('doctor_note.index')->with('success', 'Cập nhật lời dặn thành công!');
    }

    public function destroy($id)
    {
        try {
            // Tìm bản ghi doctor_note
            $doctor_note = Doctor_notes::findOrFail($id);
    
            // Thử xóa bản ghi doctor_note (sẽ gây lỗi nếu có bản ghi liên quan trong bảng examinations)
            $doctor_note->delete();
    
            return redirect()->route('doctor_note.index')->with('success', 'Xóa lời dặn thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Nếu có lỗi về ràng buộc khóa ngoại, hiển thị thông báo lỗi
            return redirect()->route('doctor_note.index')->with('error_message', 'Không thể xóa, vì có hồ sơ khám bệnh đang sử dụng lời dặn này.');
        }
    }
    
}
