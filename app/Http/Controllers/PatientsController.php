<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
// use request
use App\Http\Requests\PatientRequest;

class PatientsController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('id', $search);
        }
    
        $patients = $query->paginate(10)->appends(['search' => $request->search]);
    
        return view('patients.index', compact('patients'));
    }
    
    public function store(PatientRequest $request) 
    {
        Patient::create($request->validated());
        return redirect()->route('patients.index')->with('success', 'Bệnh nhân đã được thêm thành công.');

    }
    public function destroy($id)
    {
        $patient = Patient::find($id);
        $patient->delete();
        return redirect()->back()->with('success', 'Bệnh nhân đã được xóa!');
    }

    public function edit($id)
    {
        $patient = Patient::find($id);
        return view('patients.edit',compact('patient'));
    }

    public function update(PatientRequest $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->validated());
        return redirect('/patients')->with('success', 'Bệnh nhân đã được cập nhật thành công.');
    }
    
    
    
}
    
