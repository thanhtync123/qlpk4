<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
use App\Http\Requests\MedicationRequest;
use Illuminate\Support\Facades\DB;
class MedicationsController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');
        $medications = Medication::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);  // 10 thuốc mỗi trang (có thể thay đổi theo nhu cầu)
    
        return view('medications.index', compact('medications'));
    }
    public function search(Request $request)
    {
        $search = $request->input('search');
        $medications = Medication::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);  // Thêm phân trang vào kết quả tìm kiếm
    
        // Trả về dữ liệu thuốc và phân trang
        return response()->json([
            'medications' => $medications->items(),
            'pagination' => (string) $medications->links()
        ]);
    }


    public function store(MedicationRequest $request)
    {


        Medication::create($request->validated());
        return redirect()->route('medication.index')->with('success', 'Thêm thuốc thành công');
        
    }

    public function edit($id)
    {
        $medication = Medication::findOrFail($id);
        return view('medications.edit', compact('medication'));

        
    }

    public function update(MedicationRequest $request, $id)
    {
        $medication = Medication::findOrFail($id);
        $medication->update($request->validated());
        return redirect()->route('medication.index')->with('success', 'Cập nhật thuốc thành công');
    }

    public function destroy($id)
    {
        $medication = Medication::findOrFail($id);
        $medication->delete();
        return redirect()->route('medication.index')->with('success', 'Xóa thuốc thành công');
    }
}
