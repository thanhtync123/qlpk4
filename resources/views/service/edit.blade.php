@extends('layouts.layout')

@section('title', 'Chỉnh sửa dịch vụ')

@section('content')
<div class="container mt-4">
    <h2 class="text-center text-primary">Chỉnh sửa dịch vụ</h2>
    @include('inc._success')
    @include('inc._errors')
    <form action="{{ route('service.update', $service->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tên dịch vụ</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $service->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $service->price) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Loại dịch vụ</label>
            <select name="type" class="form-control" required>
                <option value="X-quang" {{ $service->type == 'X-quang' ? 'selected' : '' }}>X-quang</option>
                <option value="Điện tim" {{ $service->type == 'Điện tim' ? 'selected' : '' }}>Điện tim</option>
                <option value="Xét nghiệm" {{ $service->type == 'Xét nghiệm' ? 'selected' : '' }}>Xét nghiệm</option>
                <option value="Siêu âm" {{ $service->type == 'Siêu âm' ? 'selected' : '' }}>Siêu âm</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nội dung</label>
            <textarea name="content" class="form-control" rows="3">{{ old('content', $service->content) }}</textarea>
        </div>


        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('service.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

@endsection

