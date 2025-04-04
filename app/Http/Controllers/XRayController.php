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
use Carbon\Carbon;

class XRayController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $resultFilter = $request->input('result_filter', 'all'); // 'all', 'with_result', 'without_result'
    
        // Query bệnh nhân đã được chỉ định dịch vụ X-quang
        $patients = Patient::query()
            ->join('examinations', 'patients.id', '=', 'examinations.patient_id')
            ->join('examination_services', 'examinations.id', '=', 'examination_services.examination_id')
            ->join('services', 'examination_services.service_id', '=', 'services.id')
            ->where('services.type', 'X-quang')
            ->select('patients.*')
            ->distinct();
    
        // Filter by result status
        if ($resultFilter === 'with_result') {
            $patients->join('examination_results', 'examination_services.id', '=', 'examination_results.examination_service_id')
                ->where(function($query) {
                    $query->whereNotNull('examination_results.result')
                        ->orWhereNotNull('examination_results.final_result')
                        ->orWhereNotNull('examination_results.file_path');
                });
        } elseif ($resultFilter === 'without_result') {
            $patients->leftJoin('examination_results', 'examination_services.id', '=', 'examination_results.examination_service_id')
                ->where(function($query) {
                    $query->whereNull('examination_results.id')
                        ->orWhere(function($q) {
                            $q->whereNull('examination_results.result')
                                ->whereNull('examination_results.final_result')
                                ->whereNull('examination_results.file_path');
                        });
                });
        }
    
        // Filter by date range
        if ($startDate) {
            $patients->whereDate('patients.created_at', '>=', Carbon::parse($startDate)->startOfDay());
        }
        if ($endDate) {
            $patients->whereDate('patients.created_at', '<=', Carbon::parse($endDate)->endOfDay());
        }
    
        // Get patients
        $patients = $patients->orderBy('patients.created_at', 'desc')->get();
        $selectedPatientId = $request->input('patient_id');
        $templates = Template::all();
        $services = [];
    
        if ($selectedPatientId) {
            $services = DB::table('examinations')
                ->join('examination_services', 'examinations.id', '=', 'examination_services.examination_id')
                ->join('services', 'examination_services.service_id', '=', 'services.id')
                ->where('examinations.patient_id', $selectedPatientId)
                ->where('services.type', 'X-quang')
                ->select(
                    'examination_services.id as examination_service_id',
                    'services.id as service_id',
                    'services.name'
                )
                ->get();
        }
    
        return view('examination.x-ray', compact(
            'templates',
            'patients', 
            'services', 
            'selectedPatientId',
            'resultFilter'
        ));
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