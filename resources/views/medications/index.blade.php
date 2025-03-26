@extends('layouts.layout')

@section('title', 'Danh sách thuốc')

@section('content')
<div class="container mt-4">
    <h2>Danh sách thuốc</h2>
    @include('inc._errors')
    @include('inc._success')

    <!-- Nút thêm thuốc -->
    <a href="#" class="btn btn-success rounded-circle position-fixed"
       style="right: 30px; bottom: 30px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);"
       data-bs-toggle="modal" data-bs-target="#addMedicationModal">
        +
    </a>

    <!-- Thanh tìm kiếm -->
    <form action="{{ route('medication.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" id="search" name="search" class="form-control" placeholder="Nhập tên thuốc..." value="{{ request('search') }}">
        </div>
    </form>

    <!-- Bảng danh sách thuốc -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên thuốc</th>
                <th>Đơn vị</th>
                <th>Liều dùng</th>
                <th>Đường dùng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($medications as $medication)
            <tr>
                <td>{{ $medication->id }}</td>
                <td>{{ $medication->name }}</td>
                <td>{{ $medication->unit }}</td>
                <td>{{ $medication->dosage }}</td>
                <td>{{ $medication->route }}</td>
                <td>
                    <a href="{{ route('medication.edit', $medication->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    
                    <form action="{{ route('medication.delete', $medication->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Không tìm thấy thuốc</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
        {{ $medications->links('pagination::bootstrap-4') }}
    </div>

</div>
@include('modals._add_medication')
@endsection