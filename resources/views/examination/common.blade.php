@extends('layouts.layout')

@section('title', 'Khám bệnh')

@section('content')
    @include('examination.nav')
    <br><br>
    @include('inc._errors')
    @include('inc._success')
    <br>
    <div class="container-fluid mt-5">
        <div class="bg-primary text-white p-2 fw-bold">{{ $title }}</div>
        <form action="{{ url('examination/'.$type.'/store') }}" method="POST" id="xray-form" enctype="multipart/form-data">
            @csrf <!-- Bảo vệ chống CSRF -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header bg-light fw-bold">Thông tin bệnh nhân</div>
                        <div class="card-body">
                            <div class="mb-3 row align-items-center">
                                <label for="patient-select" class="col-sm-3 col-form-label">Mã BN <span class="required">*</span></label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select name="patient_id" id="patient-select" class="form-select" required>
                                            <option value="">-- Chọn bệnh nhân --</option>
                                            @foreach ($patients as $item)
                                                <option value="{{ $item->id }}"
                                                        data-name="{{ $item->name }}"
                                                        data-date_of_birth="{{ $item->date_of_birth }}"
                                                        data-gender="{{ $item->gender }}"
                                                        data-address="{{ $item->address }}">
                                                    {{ $item->name }} (ID: {{ $item->id }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                        <button class="btn btn-outline-danger" type="button">Lịch sử</button>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="patient-name" class="col-sm-3 col-form-label">Họ tên</label>
                                <div class="col-sm-5">
                                    <input type="text" id="patient-name" class="form-control" readonly>
                                </div>
                                <label for="patient-gender" class="col-sm-2 col-form-label">Giới tính</label>
                                <div class="col-sm-2">
                                    <input type="text" id="patient-gender" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="patient-address" class="col-sm-3 col-form-label">Địa chỉ</label>
                                <div class="col-sm-5">
                                    <input type="text" id="patient-address" class="form-control" readonly>
                                </div>
                                <label for="patient-dob" class="col-sm-2 col-form-label">Ngày sinh</label>
                                <div class="col-sm-2">
                                    <input type="text" id="patient-dob" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header bg-light fw-bold">Thông tin khám</div>
                        <div class="card-body">
                            <input type="hidden" name="examination_id" value = "{{ $newExaminationId }}">
                            <p>Mã phiếu khám: <span>{{ $newExaminationId }}</span></p>
                            <div class="mb-3 row align-items-center">
                                <label for="total-amount-display" class="col-sm-3 col-form-label">Tổng tiền</label>
                                <div class="col-sm-4">
                                    <input type="hidden" id="total-amount-raw" name="total_price" value="0">
                                    <input type="text" id="total-amount-display" class="form-control" value="0" readonly>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="patient-diagnosis" class="col-sm-3 col-form-label">Chẩn đoán</label>
                                <div class="col-sm-9">
                                    <input type="text" id="patient-diagnosis" class="form-control" name="diagnosis">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="diagnosis-conclusion" class="form-label">Kết luận</label>
                                <textarea id="diagnosis-conclusion" class="form-control" rows="3" name="conclusion"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Phần thuốc - Hiển thị khi chọn checkbox -->
                    <div id="medicine-section" class="card mb-3" style="display: none;">
                        <div class="card-header bg-light fw-bold">Kê đơn thuốc</div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <label for="medicine-select" class="form-label">Chọn thuốc</label>
                                    <select id="medicine-select" class="form-select">
                                        <option value="">-- Chọn thuốc --</option>
                                        <!-- Giả sử có danh sách thuốc, bạn cần thay thế bằng dữ liệu thật -->
                                        <option value="1" data-name="Paracetamol 500mg">Paracetamol 500mg</option>
                                        <option value="2" data-name="Amoxicillin 500mg">Amoxicillin 500mg</option>
                                        <option value="3" data-name="Vitamin C 1000mg">Vitamin C 1000mg</option>
                                         <option value="4" data-name="Mefenamic acid 500mg">Mefenamic acid 500mg</option>
                                        <option value="5" data-name="Cetirizine 10mg">Cetirizine 10mg</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label for="medicine-instruction" class="form-label">Lời dặn</label>
                                    <input type="text" id="medicine-instruction" class="form-control" placeholder="Nhập lời dặn">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" id="add-medicine-btn" class="btn btn-success">Thêm thuốc</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="medicine-table" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th width="5%">STT</th>
                                            <th width="30%">Tên thuốc</th>
                                            <th width="45%">Lời dặn</th>
                                            <th width="20%">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Form thêm hình ảnh (ẩn ban đầu) -->
                    <div id="image-upload-section" class="card mb-3" style="display: none;">
                        <div class="card-header bg-light fw-bold">Tải lên hình ảnh</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Chọn hình ảnh</label>
                                <input type="file" name="image[]" class="form-control" accept=".jpg,.jpeg,.png" multiple id="image-input">
                            </div>
                            <div id="image-preview" class="row">
                                <!-- Nơi hiển thị ảnh đã chọn -->
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header bg-light fw-bold">Dịch vụ khám</div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Chọn</th>
                                            <th>Tên dịch vụ</th>
                                            <th>Đơn giá</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $item)
                                            <tr>
                                                <td><input type="checkbox" class="form-check-input service-checkbox" value="{{$item->id}}" data-price="{{$item->price}}" data-name="{{$item->name}}"></td>
                                                <td>{{$item->name}}</td>
                                                <td>{{number_format($item->price)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2">
                                <button id="add-service-btn" class="btn btn-primary" type="button">Thêm dịch vụ</button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Thêm checkbox cho phần thuốc -->
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="medicine-checkbox">
                                <label class="form-check-label fw-bold" for="medicine-checkbox">
                                    Thêm thuốc cho bệnh nhân
                                </label>
                            </div>
                            <!-- Thêm checkbox cho phần hình ảnh -->
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="image-checkbox">
                                <label class="form-check-label fw-bold" for="image-checkbox">
                                    Thêm hình ảnh
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-light fw-bold">Dịch vụ đã chọn</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="selected-services" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th>Mã DV</th>
                                            <th>Tên dịch vụ</th>
                                            <th>Thành tiền</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Lưu thông tin</button>
                 <a href="{{ url('examination/'.$type.'/print/'.$newExaminationId-1) }}" target="_blank" class="btn btn-secondary">In phiếu khám</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Xử lý dịch vụ khám
            const addButton = document.getElementById("add-service-btn");
            const selectedTable = document.querySelector("#selected-services tbody");
            const totalAmountRawInput = document.getElementById("total-amount-raw");
            const totalAmountDisplayInput = document.getElementById("total-amount-display");
            let totalAmount = 0;
            const selectedServices = {}; // Object to track selected services

            addButton.addEventListener("click", function () {
                let checkboxes = document.querySelectorAll(".service-checkbox:checked");
                checkboxes.forEach((checkbox) => {
                    let row = checkbox.closest("tr");
                    let serviceId = checkbox.value;
                    let serviceName = checkbox.dataset.name;
                    let price = parseFloat(checkbox.dataset.price);

                    // Check if the service is already added
                    if (selectedServices[serviceId]) {
                        alert("Dịch vụ này đã được thêm.");
                        return;
                    }

                    let newRow = document.createElement("tr");
                    newRow.innerHTML = `
                        <td>${serviceId}</td>
                        <td>${serviceName}</td>
                        <td>${price.toLocaleString()} đ</td>
                        <td><button class="btn btn-danger btn-sm remove-btn" data-service-id="${serviceId}">Xóa</button></td>
                    `;
                    // Store service ID in the object
                    selectedServices[serviceId] = true;

                    let hiddenInput = document.createElement("input");
                    hiddenInput.type = "hidden";
                    hiddenInput.name = "service_id[]";  // Dùng mảng để gửi nhiều service_id
                    hiddenInput.value = serviceId;
                    newRow.appendChild(hiddenInput);

                    selectedTable.appendChild(newRow);
                    totalAmount += price;
                });
                updateTotalAmount();
                checkboxes.forEach((checkbox) => checkbox.checked = false);
            });

            document.addEventListener("click", function (event) {
                if (event.target.classList.contains("remove-btn")) {
                    let row = event.target.closest("tr");
                    let serviceId = event.target.dataset.serviceId; // Get service ID from the button

                    let priceText = row.cells[2].textContent;
                    let price = parseFloat(priceText.replace(/[^\d\,]/g, '').replace(/\,/g, '')); // Remove non-numeric characters and handle commas

                    totalAmount -= price;
                    delete selectedServices[serviceId]; // Remove service ID from the object
                    row.remove();
                    updateTotalAmount();
                }
            });

            function updateTotalAmount() {
                totalAmountRawInput.value = totalAmount; // Set raw value (number)
                totalAmountDisplayInput.value = totalAmount.toLocaleString('vi-VN'); // Set formatted value for display
            }
            
            // Xử lý thông tin bệnh nhân
            document.getElementById("patient-select").addEventListener("change", function () {
                let selectedOption = this.options[this.selectedIndex];
                document.getElementById("patient-name").value = selectedOption.getAttribute("data-name") || "";
                document.getElementById("patient-dob").value = selectedOption.getAttribute("data-date_of_birth") || "";
                document.getElementById("patient-gender").value = selectedOption.getAttribute("data-gender") || "";
                document.getElementById("patient-address").value = selectedOption.getAttribute("data-address") || "";
            });
            
            // Xử lý phần thuốc
            const medicineCheckbox = document.getElementById("medicine-checkbox");
            const medicineSection = document.getElementById("medicine-section");
            const medicineSelect = document.getElementById("medicine-select");
            const medicineInstruction = document.getElementById("medicine-instruction");
            const addMedicineBtn = document.getElementById("add-medicine-btn");
            const medicineTable = document.querySelector("#medicine-table tbody");
            let medicineCounter = 1;
            
            medicineCheckbox.addEventListener("change", function() {
                if (this.checked) {
                    medicineSection.style.display = "block";
                } else {
                    medicineSection.style.display = "none";
                }
            });
            
            addMedicineBtn.addEventListener("click", function() {
                const selectedMedicine = medicineSelect.options[medicineSelect.selectedIndex];
                const medicineId = medicineSelect.value;
                const medicineName = selectedMedicine.getAttribute("data-name");
                const instruction = medicineInstruction.value;
                
                if (!medicineId) {
                    alert("Vui lòng chọn thuốc");
                    return;
                }
                
                // Tạo dòng mới trong bảng thuốc
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td>${medicineCounter}</td>
                    <td>${medicineName}</td>
                    <td>${instruction}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-medicine-btn">Xóa</button>
                    </td>
                `;
                
                // Thêm input ẩn để lưu thông tin thuốc
                const medicineIdInput = document.createElement("input");
                medicineIdInput.type = "hidden";
                medicineIdInput.name = "medicine_id[]";
                medicineIdInput.value = medicineId;
                newRow.appendChild(medicineIdInput);
                
                const instructionInput = document.createElement("input");
                instructionInput.type = "hidden";
                instructionInput.name = "medicine_instruction[]";
                instructionInput.value = instruction;
                newRow.appendChild(instructionInput);
                
                medicineTable.appendChild(newRow);
                medicineCounter++;
                
                // Reset form
                medicineSelect.value = "";
                medicineInstruction.value = "";
            });
            
            // Xử lý xóa thuốc
            document.addEventListener("click", function(event) {
                if (event.target.classList.contains("remove-medicine-btn")) {
                    const row = event.target.closest("tr");
                    row.remove();
                    
                    // Cập nhật lại STT
                    const rows = medicineTable.querySelectorAll("tr");
                    rows.forEach((row, index) => {
                        row.cells[0].textContent = index + 1;
                    });
                    
                    medicineCounter = rows.length + 1;
                }
            });
             // Xử lý hiển thị và xóa ảnh
    const imageCheckbox = document.getElementById("image-checkbox");
    const imageUploadSection = document.getElementById("image-upload-section");
    const imageInput = document.getElementById("image-input");
    const previewContainer = document.getElementById("image-preview");

    // Hiển thị hoặc ẩn khu vực tải ảnh khi checkbox thay đổi
    imageCheckbox.addEventListener("change", function () {
        imageUploadSection.style.display = this.checked ? "block" : "none";
    });

    // Xử lý khi chọn ảnh
    imageInput.addEventListener("change", function (event) {
        previewContainer.innerHTML = ""; // Xóa các ảnh cũ
        const files = event.target.files;

        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const imgContainer = document.createElement("div");
                    imgContainer.classList.add("col-md-3", "mb-3"); // Thêm class Bootstrap để tạo grid
                    imgContainer.innerHTML = `
                        <img src="${e.target.result}" alt="Uploaded Image" class="img-fluid">
                        <button type="button" class="btn btn-danger btn-sm remove-image-btn" data-index="${i}">Xóa</button>
                    `;
                    previewContainer.appendChild(imgContainer);
                }

                reader.readAsDataURL(file);
            }
        }
    });

    // Xử lý xóa ảnh
    previewContainer.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-image-btn")) {
            const indexToRemove = parseInt(event.target.dataset.index);
            const dt = new DataTransfer()
            const { files } = imageInput

            for (let i = 0; i < files.length; i++) {
                const file = files[i]
                if (i !== indexToRemove) {
                    dt.items.add(file)
                }
            }

            imageInput.files = dt.files;
            event.target.closest('.col-md-3').remove(); // Xóa khỏi giao diện
        }
    });
        });
    </script>
@endsection