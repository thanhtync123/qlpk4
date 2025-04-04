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
        $patients = Patient::whereDate('updated_at', today())
        ->latest('updated_at')
        ->get();
        $doctor_notes = Doctor_notes::all();
        $diagnoses = Diagnoses::all();
        $medications = Medication::all();
        $services = Service::all();
        $exam_id_med = Examination::where('type', 'toa thuốc')->max('id') + 1;
        $exam_id_ser = Examination::where('type', 'chỉ định')->max('id') + 1;
        return view('examination.examination'
        ,compact(
        'patients','exam_id_med','exam_id_ser','doctor_notes','diagnoses','medications','services'
        ));
    }
    public function storeMedication(Request $request)
    {
        //  dd($request->all());
        DB::beginTransaction();
        try {
            // 1. Lưu thông tin lần khám
            $examination = Examination::create([
                'patient_id' => $request->patient_id,
                'reason' => $request->reason,
                'symptoms' => $request->symptoms,
                'diagnosis_id' => $request->diagnosis_id,
                'doctor_note_id' => $request->doctor_note_id,
                'type' => "toa thuốc",
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
                    'quantity' => $med['quantity'],
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
                'type' => "chỉ định",
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
    public function print_prescription(Request $request, $id)
{
    $prescriptionDetails = DB::table('examinations as e')
    ->join('patients as p', 'p.id', '=', 'e.patient_id')
    ->join('examination_medications as em', 'em.examination_id', '=', 'e.id')
    ->join('diagnoses as d', 'd.id', '=', 'e.diagnosis_id')
    ->join('doctor_notes as dn', 'dn.id', '=', 'e.doctor_note_id')
    ->join('medications as m', 'm.id', '=', 'em.medication_id')
    ->select(
        'e.id as examination_id',
        'p.id as patient_id',
        'p.name as patient_name',
        'p.date_of_birth as patient_date_of_birth',
        'p.gender as patient_gender',
        'p.phone as patient_phone',
        'p.address as patient_address',
        'em.medication_id as medication_id',
        'm.name as medication_name',
        'em.unit as unit',
        'em.dosage as dosage',
        'em.route as route',
        'em.times as times_per_day',
        'em.note as note',
        'em.quantity as quantity',
        'em.price as price_per_unit',
        DB::raw('(em.price * em.quantity) as total_price_per_item'),
        'd.name as diagnosis_name',  
        'dn.content as doctor_note_content',  
        'e.reason as examination_reason', 
        'e.symptoms as examination_symptoms' 
    )
    ->where('e.id', $id)
    ->get();

return view('print.print_examination_prescription', compact('prescriptionDetails'));

}
public function print_service(Request $request,$id)
{
    $examinationService = DB::table('examinations as e')
        ->join('patients as p', 'e.patient_id', '=', 'p.id')
        ->join('examination_services as es', 'e.id', '=', 'es.examination_id')
        ->join('services as s', 'es.service_id', '=', 's.id')
        ->select(
            'e.id as Mã phiếu khám',
            'p.name as Tên bệnh nhân',
            'p.date_of_birth as Ngày sinh',
            'p.gender as Giới tính',
            'p.phone as Số điện thoại',
            'p.address as Địa chỉ',
            's.id as Mã dịch vụ',
            's.name as Tên dịch vụ',
            's.type as Loại dịch vụ',
            'es.price as Đơn giá',
            's.price as Giá gốc'
        )
        ->where('e.id', $id)
        ->get();

    return view('print.print_examination_service', compact('examinationService'));
}


        
    

 
    

    }

