@extends('layouts.layout')

@section('title', 'Danh sách ghi chú bác sĩ')

@section('content')
<div class="container mt-4">
    <h2>Danh sách ghi chú bác sĩ</h2>
    @include('inc._errors')
    @include('inc._success')

    <!-- Nút thêm ghi chú bác sĩ -->
    <a href="#" class="btn btn-success rounded-circle position-fixed"
       style="right: 30px; bottom: 30px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);"
       data-bs-toggle="modal" data-bs-target="#addDoctorNoteModal">
        +
    </a>

    <!-- Bảng danh sách ghi chú bác sĩ -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>

                <th>Chi tiết</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($doctorNotes as $doctorNote)
            <tr>
                <td>{{ $doctorNote->id }}</td>
    
                <td>{{ $doctorNote->content }}</td>
                <td>
                    <a href="{{ route('doctor_note.edit', $doctorNote->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('doctor_note.destroy', $doctorNote->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Không có ghi chú bác sĩ</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center">
        {{ $doctorNotes->links('pagination::bootstrap-4') }}
    </div>

</div>
@include('modals._add_doctornote')
@endsection
