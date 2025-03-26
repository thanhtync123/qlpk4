@extends('layouts.layout')

@section('title', 'Sửa thuốc')

@section('content')
<div class="container mt-4">
    <h2>Sửa thuốc</h2>

    <!-- Hiển thị thông báo lỗi nếu có -->
    @include('inc._errors')
    @include('inc._success')

    <!-- Form sửa thuốc -->
    <form action="{{ route('medication.update', $medication->id) }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label for="name" class="form-label">Tên thuốc</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $medication->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Đơn vị</label>
            <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit', $medication->unit) }}" required>
        </div>

        <div class="mb-3">
            <label for="dosage" class="form-label">Liều dùng</label>
            <input type="text" class="form-control" id="dosage" name="dosage" value="{{ old('dosage', $medication->dosage) }}" required>
        </div>

        <div class="mb-3">
            <label for="route" class="form-label">Đường dùng</label>
            <input type="text" class="form-control" id="route" name="route" value="{{ old('route', $medication->route) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
