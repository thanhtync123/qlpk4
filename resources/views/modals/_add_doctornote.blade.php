<div class="modal fade" id="addDoctorNoteModal" tabindex="-1" aria-labelledby="addDoctorNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('doctor_note.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDoctorNoteModalLabel">Thêm ghi chú bác sĩ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  
                    <div class="mb-3">
                        <label for="content" class="form-label">Chi tiết ghi chú</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
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
