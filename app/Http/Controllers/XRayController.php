<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Examination;
use App\Models\Examination_services;
use App\Models\Template;
use App\Models\Examination_results;
use Illuminate\Support\Facades\DB; 

class XRayController extends Controller
{
    public function index(Request $request)
    {
        $patients = Patient::all();
        $selectedPatientId = $request->input('patient_id');
        $templates = Template::all();
        $services = [];
        if ($selectedPatientId) {
            $services = DB::table('examinations')
            ->join('examination_services', 'examinations.id', '=', 'examination_services.examination_id')
            ->join('services', 'examination_services.service_id', '=', 'services.id')
            ->where('examinations.patient_id', $selectedPatientId)
            ->select(
                'examination_services.id as examination_service_id', 
                'services.id as service_id',
                'services.name'
            )
            ->get();
        
        }

        return view('examination.x-ray', compact('templates','patients', 'services', 'selectedPatientId'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'examination_service_id' => 'required|exists:examination_services,id',
            'template_id' => 'required|exists:templates,id',
            'result' => 'required|string',
           // 'file_path' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
        ]);
        $examinationResult = new Examination_results();
        $examinationResult->examination_service_id = $request->examination_service_id;
        $examinationResult->template_id = $request->template_id;
        $examinationResult->result = $request->result;
        //$examinationResult->file_path = $filePath;
        $examinationResult->save();
        return redirect()->back()->with('success', 'Lưu kết quả thành công!');

    }
}
