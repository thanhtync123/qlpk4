@extends('layouts.layout')

@section('title', 'Danh sách chẩn đoán')

@section('content')
<div class="container mt-4">
    <h2>Danh sách chẩn đoán</h2>

    @include('inc._errors')
    @include('inc._success')

    <!-- Nút thêm chẩn đoán -->
    <a href="#" class="btn btn-success rounded-circle position-fixed"
       style="right: 30px; bottom: 30px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);"
       data-bs-toggle="modal" data-bs-target="#addDiagnoseModal">
        +
    </a>

    <!-- Bảng danh sách chẩn đoán -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên chẩn đoán</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diagnoses as $diagnose)
            <tr>
                <td>{{ $diagnose->id }}</td>
                <td>{{ $diagnose->name }}</td>
                <td>
                    <a href="{{ route('diagnose.edit', $diagnose->id) }}" class="btn btn-warning btn-sm">Sửa</a>

                    <form action="{{ route('diagnose.destroy', $diagnose->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('modals._add_diagnose')

@endsection
