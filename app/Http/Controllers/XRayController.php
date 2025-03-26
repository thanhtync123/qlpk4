<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Examination;
use App\Models\Medication;
use App\Models\Examination_services;
use App\Models\Examination_medications; // Thêm model Examination_medications

class XRayController extends Controller
{
    public function index(Request $request)
    {
       
    
    }
    
    public function print($id)
    {
        $examination = Examination::with(['patient', 'services', 'medications'])->findOrFail($id);
        return view('print._xray_examination', compact('examination'));
    }

    public function showXRayForm() {
        $medications = Medication::all();
        $patients = Patient::all();
        $services = Service::all(); // Thêm danh sách dịch vụ
        $newExaminationId = Examination::max('id') + 1;
        $title = 'Phiếu khám X-Quang';
        $type = 'x-ray';
        return view('examination.x-ray', compact('medications', 'patients', 'services', 'newExaminationId', 'title', 'type'));
    }
    
    public function showECGForm() {
        $medications = Medication::all();
        $patients = Patient::all();
        $services = Service::all(); // Thêm danh sách dịch vụ
        $newExaminationId = Examination::max('id') + 1;
        $title = 'Phiếu khám điện tim (ECG)';
        $type = 'ecg';
        return view('examination.ecg', compact('medications', 'patients', 'services', 'newExaminationId', 'title', 'type'));
    }
    
    public function showTestForm() {
        $medications = Medication::all();
        $patients = Patient::all();
        $services = Service::all(); // Thêm danh sách dịch vụ
        $newExaminationId = Examination::max('id') + 1;
        $title = 'Phiếu xét nghiệm';
        $type = 'test';
        return view('examination.test', compact('medications', 'patients', 'services', 'newExaminationId', 'title', 'type'));
    }
    

    public function store(Request $request)
    {
       
       //  dd(request()->all());
        $request->validate([
            'patient_id'   => 'required|exists:patients,id', // Bệnh nhân phải tồn tại trong bảng patients
            'diagnosis'    => 'required|string|max:255', // Chẩn đoán không được để trống, tối đa 255 ký tự
            'total_price'  => 'required|numeric|min:0', // Tổng tiền phải là số và không âm
            'conclusion'   => 'nullable|string|max:500', // Kết luận có thể rỗng nhưng không quá 500 ký tự
             'image.*'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ảnh phải là hình ảnh hợp lệ, tối đa 2MB
            'examination_id' => 'required|integer', // Thêm validation cho examination_id
            'medicine_id.*' => 'nullable|exists:medications,id', // Validate mảng medicine_id
            'medicine_instruction.*' => 'nullable|string|max:255', // Validate mảng medicine_instruction
        ], [
            'patient_id.required'  => 'Vui lòng chọn bệnh nhân.',
            'patient_id.exists'    => 'Bệnh nhân không tồn tại.',
            'diagnosis.required'   => 'Vui lòng nhập chẩn đoán.',
            'diagnosis.max'        => 'Chẩn đoán không được vượt quá 255 ký tự.',
            'total_price.required' => 'Vui lòng nhập tổng tiền.',
            'total_price.numeric'  => 'Tổng tiền phải là số.',
            'total_price.min'      => 'Tổng tiền không được nhỏ hơn 0.',
            'conclusion.max'       => 'Kết luận không được vượt quá 500 ký tự.',
            'image.image'          => 'Tệp phải là hình ảnh.',
            'image.mimes'          => 'Ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'image.max'            => 'Ảnh không được lớn hơn 2MB.',
            'examination_id.required' => 'Thiếu mã phiếu khám.',
            'examination_id.integer' => 'Mã phiếu khám không hợp lệ.',
            'medicine_id.*.exists'   => 'Thuốc không tồn tại trong hệ thống.',
            'medicine_instruction.*.max' => 'Lời dặn không được vượt quá 255 ký tự.',
        ]);

        // Nếu validate thành công, tiếp tục lưu vào database
        $examination = new Examination(); // Tạo một instance mới
        $examination->patient_id  = $request->patient_id;
        $examination->diagnosis   = $request->diagnosis;
        $examination->total_price = $request->total_price;
        $examination->conclusion  = $request->conclusion;
        
        if ($request->hasFile('image')) {
            $imageFiles = $request->file('image'); 
        
            if (!is_array($imageFiles)) {
                $imageFiles = [$imageFiles];
            }
        
            $imageNames = [];
        
            foreach ($imageFiles as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $destinationPath = public_path('images'); // Đường dẫn thư mục public/images
                    $image->move($destinationPath, $imageName); // Di chuyển file
                    $imageNames[] = 'images/' . $imageName;
                }
            }
        
            if (!empty($imageNames)) {
                $examination->image = implode(',,', $imageNames);
            }
        }
        
        
        // Lưu vào database
        $examination->save();
        
        
        
        
        $examination->save(); // Lưu vào database và lấy ID

        $examinationId = $examination->id;

        // Xử lý thêm dịch vụ
        if ($request->has('service_id')) {
            foreach ($request->service_id as $serviceId) {
                $service = Service::find($serviceId); // Tìm service tương ứng
                if ($service) { // Kiểm tra service có tồn tại không
                    Examination_services::create([
                        'examination_id' => $examinationId,
                        'service_id' => $serviceId,
                        'price' => $service->price ?? 0 // Lấy giá từ service, nếu không có thì mặc định là 0
                    ]);
                } else {
                    // Xử lý trường hợp service không tồn tại (ví dụ: log lỗi, bỏ qua service này)
                    \Log::error("Service with ID {$serviceId} not found.");
                }
            }
        }
        
        // Xử lý thêm thuốc
        if ($request->has('medicine_id') && $request->has('medicine_instruction')) {
            $medicineIds = $request->medicine_id;
            $medicineInstructions = $request->medicine_instruction;
            
            // Đảm bảo hai mảng có cùng độ dài
            $count = min(count($medicineIds), count($medicineInstructions));
            
            for ($i = 0; $i < $count; $i++) {
                if (!empty($medicineIds[$i])) {
                    // Kiểm tra thuốc có tồn tại không
                    $medication = Medication::find($medicineIds[$i]);
                    if ($medication) {
                        // Thêm vào bảng examination_medications
                        Examination_medications::create([
                            'examination_id' => $examinationId,
                            'medication_id' => $medicineIds[$i],
                            'note' => $medicineInstructions[$i] ?? ''
                        ]);
                    } else {
                        \Log::error("Medication with ID {$medicineIds[$i]} not found.");
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Lưu thông tin khám bệnh thành công.');
    }
}