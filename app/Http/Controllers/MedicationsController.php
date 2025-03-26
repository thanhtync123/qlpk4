<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medication;
use App\Http\Requests\MedicationRequest;

class MedicationsController extends Controller
{
    public function index(Request $request)
    {
        // Tìm kiếm thuốc nếu có
        $search = $request->input('search');
        $medications = Medication::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->paginate(10);  // Phân trang 10 thuốc mỗi trang

        return view('medications.index', compact('medications'));
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
