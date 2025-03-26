@extends('layouts.layout')

@section('title', 'Sửa thông tin bệnh nhân')

@section('content')
<div class="modal-body">
    <form action="{{ url('/patients/update/' . $patient->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="name" name="name" 
                   value="{{ old('name', $patient->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Ngày sinh</label>
            <input type="date" class="form-control" id="dob" name="date_of_birth" 
                   value="{{ old('date_of_birth', $patient->date_of_birth) }}" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Giới tính</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="Nam" {{ old('gender', $patient->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ old('gender', $patient->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" id="phone" name="phone" 
                   value="{{ old('phone', $patient->phone) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" id="address" name="address" 
                   value="{{ old('address', $patient->address) }}">
        </div>

        <button type="submit" class="btn btn-success">Lưu</button>
    </form>
</div>
@endsection
