<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn Dịch Vụ Khám Bệnh</title>
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
    @if($examinationService->isNotEmpty())
        <div class="invoice-container">
            <div class="invoice-header">
                <h2>Hóa Đơn Dịch Vụ Khám Bệnh</h2>
                <p><strong>Mã phiếu khám:</strong> {{ $examinationService[0]->{'Mã phiếu khám'} }}</p>
            </div>

            <div class="patient-info">
                <div>
                    <p><strong>Bệnh nhân:</strong> {{ $examinationService[0]->{'Tên bệnh nhân'} }}</p>
                    <p><strong>Ngày sinh:</strong> {{ \Carbon\Carbon::parse($examinationService[0]->{'Ngày sinh'})->format('d-m-Y') }}</p>
                    <p><strong>Giới tính:</strong> {{ $examinationService[0]->{'Giới tính'} }}</p>
                </div>
                
                <div>
                    <p><strong>Số điện thoại:</strong> {{ $examinationService[0]->{'Số điện thoại'} }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $examinationService[0]->{'Địa chỉ'} }}</p>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên dịch vụ</th>
                        <th>Loại dịch vụ</th>
                        <th>Đơn giá</th>
                        <th>Giá gốc</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($examinationService as $index => $service)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $service->{'Tên dịch vụ'} }}</td>
                            <td>{{ $service->{'Loại dịch vụ'} }}</td>
                            <td>{{ number_format($service->{'Đơn giá'}, 0, ',', '.') }}</td>
                            <td>{{ number_format($service->{'Giá gốc'}, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-price text-right">
                <p><strong>Tổng tiền:</strong> 
                    {{ number_format($examinationService->sum('Đơn giá'), 0, ',', '.') }} VND
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
