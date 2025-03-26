@extends('layouts.layout')

@section('title', 'Trang chủ')

@section('content')
<div class="row">
    <!-- Hàng 1: Thống kê chính -->
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">👥 Bệnh nhân</h5>
                <p class="card-text fs-4">150</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">📅 Lịch hẹn</h5>
                <p class="card-text fs-4">45</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">💊 Thuốc</h5>
                <p class="card-text fs-4">80</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">🔬 Dịch vụ</h5>
                <p class="card-text fs-4">25</p>
            </div>
        </div>
    </div>

    <!-- Hàng 2: Doanh thu + Thống kê cận lâm sàng -->
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">💰 Doanh thu hôm nay</h5>
                <p class="card-text fs-4">50,000,000 VND</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-secondary mb-3">
            <div class="card-body">
                <h5 class="card-title">🩺 Số ca X-quang</h5>
                <p class="card-text fs-4">30</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-dark mb-3">
            <div class="card-body">
                <h5 class="card-title">❤️ Số ca Điện tim</h5>
                <p class="card-text fs-4">20</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">🧪 Số ca Xét nghiệm</h5>
                <p class="card-text fs-4">40</p>
            </div>
        </div>
    </div>
</div>

<!-- Danh sách bệnh nhân -->
<div class="card mt-3">
    <div class="card-header bg-primary text-white">
        📋 Danh sách bệnh nhân gần đây
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Họ tên</th>
                    <th>Tuổi</th>
                    <th>Giới tính</th>
                    <th>Ngày khám</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Nguyễn Văn A</td>
                    <td>30</td>
                    <td>Nam</td>
                    <td>17/03/2025</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Trần Thị B</td>
                    <td>25</td>
                    <td>Nữ</td>
                    <td>16/03/2025</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Lê Văn C</td>
                    <td>40</td>
                    <td>Nam</td>
                    <td>15/03/2025</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Phạm Thị D</td>
                    <td>35</td>
                    <td>Nữ</td>
                    <td>14/03/2025</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
