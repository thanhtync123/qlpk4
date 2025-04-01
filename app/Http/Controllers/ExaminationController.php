<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor_notes;
use App\Models\Diagnoses;
use App\Models\Medication;
use App\Models\Service;
use App\Models\Examination;
use App\Models\Examination_medications;
use App\Models\Examination_services;
use Illuminate\Support\Facades\DB;
// return response()->json(['message' => 'Đã route đến store() thành công!']);
class ExaminationController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        $doctor_notes = Doctor_notes::all();
        $diagnoses = Diagnoses::all();
        $medications = Medication::all();
        $services = Service::all();
        return view('examination.examination'
        ,compact(
        'patients','doctor_notes','diagnoses','medications','services'
        ));
    }
    public function storeMedication(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            // 1. Lưu thông tin lần khám
            $examination = Examination::create([
                'patient_id' => $request->patient_id,
                'reason' => $request->reason,
                'symptoms' => $request->symptoms,
                'diagnosis_id' => $request->diagnosis_id,
                'doctor_note_id' => $request->doctor_note_id,
                'created_at' => Carbon::now(),
            ]);
    
        //    2. Lưu danh sách thuốc kê đơn
            foreach ($request->medications as $med) {
                Examination_medications::create([
                    'examination_id' => $examination->id,
                    'medication_id' => $med['id'],
                    'unit' => $med['unit'],
                    'dosage' => $med['dosage'],
                    'route' => $med['route'],
                    'times' => $med['times'],
                    'note' => $med['note'],
                    'price' => $med['unit_price'],
                ]);
            }
    
            
            DB::commit();
            return redirect('/examination')->with('success', 'Lưu dữ liệu thành công');


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/examination')->with('error_message', 'Lỗi khi lưu dữ liệu: ' . $e->getMessage());

        }
    }
    public function storeService(Request $request)
    {
        DB::beginTransaction();
        try {
            // 1. Lưu thông tin lần khám
            $examination = Examination::create([
                'patient_id' => $request->patient_id,
                'reason' => $request->reason,
                'symptoms' => $request->symptoms,
                'diagnosis_id' => $request->diagnosis_id,
                'doctor_note_id' => $request->doctor_note_id,
                'created_at' => Carbon::now(),
            ]);

    
             // 3. Lưu danh sách dịch vụ cận lâm sàng
             foreach ($request->selected_services as $service) {
                $service_data = json_decode($service, true);
            
                if ($service_data) {
                    $serviceModel = Service::where('name', $service_data['name'])->first();
                    if ($serviceModel) {
                        Examination_services::create([
                            'examination_id' => $examination->id,
                            'service_id' => $serviceModel->id,
                            'price' => $service_data['price'],
                        ]);
                    }
                }
            }
            
            DB::commit();
            return redirect('/examination')->with('success', 'Lưu dữ liệu thành công');


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/examination')->with('error_message', 'Lỗi khi lưu dữ liệu: ' . $e->getMessage());

        }
    }

    public function store(Request $request)
    {
        // dd($request->all()); 
        DB::beginTransaction();
        try {
            // 1. Lưu thông tin lần khám
            $examination = Examination::create([
                'patient_id' => $request->patient_id,
                'reason' => $request->reason,
                'symptoms' => $request->symptoms,
                'diagnosis_id' => $request->diagnosis_id,
                'doctor_note_id' => $request->doctor_note_id,
                'created_at' => Carbon::now(),
            ]);
    
        //    2. Lưu danh sách thuốc kê đơn
            foreach ($request->medications as $med) {
                Examination_medications::create([
                    'examination_id' => $examination->id,
                    'medication_id' => $med['id'],
                    'unit' => $med['unit'],
                    'dosage' => $med['dosage'],
                    'route' => $med['route'],
                    'times' => $med['times'],
                    'note' => $med['note'],
                    'price' => $med['price'],
                ]);
            }
    
             // 3. Lưu danh sách dịch vụ cận lâm sàng
             foreach ($request->selected_services as $service) {
                $service_data = json_decode($service, true);
            
                if ($service_data) {
                    $serviceModel = Service::where('name', $service_data['name'])->first();
                    if ($serviceModel) {
                        Examination_services::create([
                            'examination_id' => $examination->id,
                            'service_id' => $serviceModel->id,
                            'price' => $service_data['price'],
                        ]);
                    }
                }
            }
            
            DB::commit();
            return redirect('/examination')->with('success', 'Lưu dữ liệu thành công');


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/examination')->with('error_message', 'Lỗi khi lưu dữ liệu: ' . $e->getMessage());

        }
    }
}
