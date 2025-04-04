@extends('layouts.layout')

@section('title', 'Danh sách bệnh nhân')

@section('content')
<div class="container mt-4">
    <h2>Danh sách bệnh nhân</h2>
    @include('inc._errors')
    @include('inc._success')
    <!-- Nút thêm bệnh nhân -->
    <a href="" class="btn btn-success rounded-circle position-fixed"
   style="right: 30px; bottom: 30px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);"
   data-bs-toggle="modal" data-bs-target="#addPatientModal">
    +
    </a>

    <!-- Thanh tìm kiếm -->
    <form action="" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" id="search" name="search" class="form-control" placeholder="Nhập ID hoặc tên bệnh nhân..." value="{{ request('search') }}">
    </div>
</form>

    <!-- Bảng danh sách bệnh nhân -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Họ và Tên</th>
                <th>Ngày sinh</th>
                <th>Tuổi</th>
                <th>Giới tính</th>
                <th>SĐT</th>
                <th>Địa chỉ</th>
                <th>Ngày tiếp nhận    </th>
                <th>Lần khám gần nhất</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($patients as $patient)
            <tr class="{{ $patient->updated_at->isToday() ? 'table-success' : '' }}">
                <td>{{ $patient->id }}</td>
                <td>{{ $patient->name }}</td>
                <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</td>
                <td>{{ $patient->gender == 'Nam' ? 'Nam' : 'Nữ' }}</td>
                <td>{{ $patient->phone }}</td>
                <td>{{ $patient->address }}</td>
                <td>{{ $patient->created_at->format('d/m/Y H:i') }}</td>
                <td class="{{ $patient->updated_at->isToday() ? 'table-success' : '' }}">
                    {{ $patient->updated_at->format('d/m/Y H:i') }}
                    @if($patient->updated_at->isToday())
                        <span class="badge bg-success">Hôm nay</span>
                    @endif
                </td>

                <td>
                    <a href="" class="btn btn-info btn-sm">Xem</a>
                    
                    <a href="{{ url('/patients/edit/' . $patient->id) }}">
                        <button class="btn btn-warning btn-sm edit-patient">
                            Sửa
                        </button>
                    </a>

                    <form action="{{ url('/patients/' . $patient->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                    
                    <a href="{{ url('/patients/re-admission/' . $patient->id) }}" >
                        <button type="button" class="btn btn-primary btn-sm">Tái tiếp nhận</button>
                    </a>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Không tìm thấy bệnh nhân</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
    {{ $patients->links('pagination::bootstrap-4') }}
</div>

</div>
@include('modals._add_patient')

@endsection
