
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn Khám Bệnh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-container {
            width: 700px;
            height: 1000px;
            border: 1px solid #000;
            padding: 20px;
        }
        .invoice-header {
            margin-bottom: 20px;
            text-align: center;
        }
        .table th, .table td {
            text-align: center;
        }
        .total-price {
            font-size: 1.5em;
            font-weight: bold;
        }
        .print-btn {
            margin-top: 20px;
        }
        .patient-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .patient-info div {
            width: 48%;
        }
    </style>
</head>
<body>

<div class="container mt-5">
@if($prescriptionDetails->isNotEmpty())
    <div class="invoice-container">
        <div class="invoice-header">
            <h2>Hóa Đơn Khám Bệnh</h2>
            <p><strong>Mã phiếu khám:</strong> {{ $prescriptionDetails[0]->examination_id }}</p>
        </div>

        <div class="patient-info">
            <div>
                <p><strong>Bệnh nhân:</strong> {{ $prescriptionDetails[0]->patient_name }}</p>
                <p><strong>Ngày sinh:</strong> {{ \Carbon\Carbon::parse($prescriptionDetails[0]->patient_date_of_birth)->format('d-m-Y') }}</p>
                <p><strong>Giới tính:</strong> {{ $prescriptionDetails[0]->patient_gender }}</p>
                <p><strong>Chẩn đoán:</strong> {{ $prescriptionDetails[0]->diagnosis_name }}</p>
                <p><strong>Lời dặn:</strong> {{ $prescriptionDetails[0]->doctor_note_content }}</p>

            </div>
            
            <div>
                <p><strong>Số điện thoại:</strong> {{ $prescriptionDetails[0]->patient_phone }}</p>
                <p><strong>Địa chỉ:</strong> {{ $prescriptionDetails[0]->patient_address }}</p>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên thuốc</th>
                    <th>Đơn vị</th>
                    <th>Liều dùng</th>
                    <th>Đường dùng</th>
                    <th>Số lần/ngày</th>
                    <th>Số lượng</th>
                   
                    <th>Giá mỗi đơn vị</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prescriptionDetails as $index => $prescription)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $prescription->medication_name }}</td>
                    <td>{{ $prescription->unit }}</td>
                    <td>{{ $prescription->dosage }}</td>
                    <td>{{ $prescription->route }}</td>
                    <td>{{ $prescription->times_per_day }}</td>
                    <td>{{ $prescription->quantity }}</td>
              
                    <td>{{ number_format($prescription->price_per_unit, 0, ',', '.') }}</td>
                    <td>{{ number_format($prescription->total_price_per_item, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-price text-right">
            <p><strong>Tổng tiền:</strong> 
                {{ number_format($prescriptionDetails->sum('total_price_per_item'), 0, ',', '.') }} VND
            </p>
        </div>

        <button class="btn btn-primary print-btn" onclick="window.print()">In Hóa Đơn</button>
    </div>
@else
    <p>Không có thông tin hóa đơn cho khám bệnh này.</p>
@endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
