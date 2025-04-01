@extends('layouts.layout')

@section('title', 'Sửa chẩn đoán')

@section('content')
<div class="container mt-4">
    <h2>Sửa chẩn đoán</h2>
    <!-- Hiển thị thông báo lỗi nếu có -->
    @include('inc._errors')
    @include('inc._success')
    <form action="{{ route('diagnose.update', $diagnose->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Tên chẩn đoán</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $diagnose->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
@endsection
