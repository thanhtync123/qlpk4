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
use Illuminate\Support\Str;


class UltrasoundController extends Controller
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
    
        return view('examination.ultrasound', compact('templates', 'patients', 'services', 'selectedPatientId'));
        }
       
    
        
      
    

    public function store(Request $request)
    {
      

        $request->validate([
            'examination_service_id' => 'required|exists:examination_services,id',
            'template_id' => 'required|exists:templates,id',
            'result' => 'required|string',
            'final_result' => 'nullable|string',
        ]);
        
        $examinationResult = new Examination_results();
        $examinationResult->examination_service_id = $request->examination_service_id;
        $examinationResult->template_id = $request->template_id;
        $examinationResult->result = $request->result;
        $examinationResult->final_result = $request->final_result;
        
        $savedImages = [];
        
        if ($request->has('captured_images') && is_array($request->captured_images)) {
            $capturedImages = json_decode($request->captured_images[0] ?? '[]', true);
        
            if (!is_array($capturedImages)) {
                return redirect()->back()->with('error', 'Dữ liệu ảnh không hợp lệ!');
            }
        
            foreach ($capturedImages as $base64Image) {
                if (strpos($base64Image, ',') !== false) {
                    list($meta, $imageData) = explode(',', $base64Image);
                    $imageData = base64_decode($imageData);
                    $fileName = Str::random(10) . '.png';
                    $filePath = public_path('images/' . $fileName);
        
                    // Lưu file vào thư mục public/images
                    file_put_contents($filePath, $imageData);
        
                    // Lưu đường dẫn ảnh tương đối
                    $savedImages[] =  $fileName;
                }
            }
        }
        
        // Lưu đường dẫn ảnh vào DB (cách nhau bởi dấu phẩy)
        $examinationResult->file_path = implode(',', $savedImages);
        $examinationResult->save();
        
        return redirect()->back()->with('success', 'Lưu kết quả thành công!');
}
}