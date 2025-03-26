<div class="modal fade" id="addMedicationModal" tabindex="-1" aria-labelledby="addMedicationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('medication.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMedicationModalLabel">Thêm thuốc mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên thuốc</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Đơn vị</label>
                        <input type="text" class="form-control" id="unit" name="unit" required>
                    </div>
                    <div class="mb-3">
                        <label for="dosage" class="form-label">Liều dùng</label>
                        <input type="text" class="form-control" id="dosage" name="dosage" required>
                    </div>
                    <div class="mb-3">
                        <label for="route" class="form-label">Đường dùng</label>
                        <input type="text" class="form-control" id="route" name="route" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </form>
    </div>
</div>