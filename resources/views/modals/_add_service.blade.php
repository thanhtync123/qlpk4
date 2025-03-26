<!-- Modal Thêm Dịch Vụ -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Thêm Dịch Vụ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('service.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên dịch vụ</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá dịch vụ</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Loại dịch vụ</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="X-quang" {{ old('type') == 'X-quang' ? 'selected' : '' }}>X-quang</option>
                            <option value="Điện tim" {{ old('type') == 'Điện tim' ? 'selected' : '' }}>Điện tim</option>
                            <option value="Xét nghiệm" {{ old('type') == 'Xét nghiệm' ? 'selected' : '' }}>Xét nghiệm</option>
                            <option value="Siêu âm" {{ old('type') == 'Siêu âm' ? 'selected' : '' }}>Siêu âm</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung</label>
                        <textarea class="form-control" id="content" name="content" rows="3">{{ old('content') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Nút mở modal -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addServiceModal">
    Thêm Dịch Vụ
</button>
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>




