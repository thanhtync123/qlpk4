@extends('layouts.layout')

@section('title', 'Sửa ghi chú bác sĩ')

@section('content')
<div class="container mt-4">
    <h2>Sửa ghi chú bác sĩ</h2>

    <!-- Hiển thị thông báo lỗi nếu có -->
    @include('inc._errors')
    @include('inc._success')

    <!-- Form sửa ghi chú bác sĩ -->
    <form action="{{ route('doctor_note.update', $doctorNote->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="content" class="form-label">Chi tiết ghi chú</label>
            <textarea class="form-control" id="content" name="content" rows="4" required>{{ old('content', $doctorNote->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
