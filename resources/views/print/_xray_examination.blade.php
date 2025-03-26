<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Kết Quả Khám Bệnh</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
@media print {
    .img-container {
        break-inside: avoid; /* Tránh việc hình bị cắt khi in */
        page-break-inside: avoid; /* Không cho hình bị xuống trang mới */
        max-width: 100mm; /* Giới hạn chiều rộng ảnh khi in */
        max-height: 100mm; /* Giới hạn chiều cao ảnh khi in */
        text-align: center; /* Căn giữa ảnh */
    }

    .img-container img {
        max-width: 100%; /* Đảm bảo ảnh không vượt quá container */
        height: auto; /* Giữ nguyên tỉ lệ */
        object-fit: contain; /* Giữ nguyên toàn bộ ảnh */
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    .col-md-4 {
        flex: 0 0 33.33%; /* Giữ đúng 3 ảnh trên một hàng */
        max-width: 33.33%;
    }
    .signature {
    text-align: right;
    margin-top: 50px;
    font-weight: bold;
}

}



    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white text-center">
                <h5 class="card-title">PHÒNG KHÁM ĐA KHOA HOÀN HẢO <i class="fas fa-hospital"></i></h5>
                <p class="card-text">456 Nguyễn Sinh Sắc, Khóm 5, P.1, TP. Sa Đéc, Đồng Tháp</p>
                <p class="card-text">
                    <i class="fas fa-phone"></i> 0971.94.93.97 |
                    <i class="fas fa-globe"></i> chandonahoanhao.com
                </p>
            </div>
            <div class="card-body">
                <h6 class="card-subtitle mb-3 text-muted">Mã phiếu khám: {{ $examination->id }}</h6>
                <h4 class="card-title text-center mb-4">PHIẾU KẾT QUẢ KHÁM BỆNH</h4>

                <section class="mb-4">
                    <h5 class="mb-3"><i class="fas fa-user"></i> I. Thông tin bệnh nhân</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Họ tên:</strong> {{ $examination->patient->name }}</p>
                            <p><strong>Năm sinh:</strong> {{ \Carbon\Carbon::parse($examination->patient->date_of_birth)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Địa chỉ:</strong> {{ $examination->patient->address }}</p>
                            <p><strong>Giới tính:</strong> {{ $examination->patient->gender }}</p>
                        </div>
                    </div>
                </section>

                <section class="mb-4">
                    <h5 class="mb-3"><i class="fas fa-notes-medical"></i> II. Chỉ định dịch vụ</h5>
                    <ul class="list-group">
                        @foreach ($examination->services as $service)
                            <li class="list-group-item">{{ $service->name }}</li>
                        @endforeach
                    </ul>
                </section>

                <section class="mb-4">
                    <h5 class="mb-3"><i class="fas fa-file-medical-alt"></i> III. Mô tả kết quả</h5>
                    <p>{{ $examination->diagnosis }}</p>
                </section>

                <section class="mb-4">
                    <h5 class="mb-3"><i class="fas fa-clipboard-check"></i> IV. Kết luận</h5>
                    <p>{{ $examination->conclusion }}</p>
                </section>

                <section class="mb-4">
                    <h5 class="mb-3"><i class="fas fa-prescription"></i> V. Đơn thuốc</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên thuốc</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($examination->medications) > 0)
                                    @foreach ($examination->medications as $medication)
                                        <tr>
                                            <td>{{ $medication->name }}</td>
                                            <td>{{ $medication->pivot->note }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2" class="text-center">Không có đơn thuốc</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="mb-4">
                    <h5 class="mb-3"><i class="fas fa-money-bill-wave"></i> VI. Chi phí</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Dịch vụ</th>
                                    <th>Giá tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalServicePrice = 0;
                                @endphp
                                @foreach ($examination->services as $service)
                                    @php $totalServicePrice += $service->price; @endphp
                                    <tr>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ number_format($service->price, 0, ',', '.') }} VND</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td><strong>Tổng tiền dịch vụ</strong></td>
                                    <td><strong>{{ number_format($totalServicePrice, 0, ',', '.') }} VND</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="mb-4">
                    <h5 class="mb-3"><i class="fas fa-images"></i> VII. Hình ảnh</h5>
                    <div class="row">
                        @if (!empty($examination->image))
                            @php
                                $images = explode(',,', $examination->image);
                            @endphp
                            @foreach ($images as $image)
                                 <div class="col-md-4 mb-3 img-container">
                                    <img src="{{ asset('images/' . basename($image)) }}" class="img-fluid rounded" alt="Hình ảnh kết quả">
                                </div>
                            @endforeach
                        @else
                            <p>Không có hình ảnh.</p>
                        @endif
                    </div>
                </section>

                <footer class="mt-5 text-right">
    <p><i>Vĩnh Long, ngày {{ $examination->created_at->format('d/m/Y') }}</i></p>
    <div class="d-inline-block text-center">
        <p><strong>Bác sĩ</strong></p>
        <br><br>
        <p><strong>BS.CKI Nguyễn Thanh Quyền</strong></p>
    </div>
</footer>


            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>