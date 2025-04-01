@extends('layouts.layout')

@section('title', 'Siêu âm')

@section('content')
    @include('examination.nav')
    @include('inc._success')
    @include('inc._errors')

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Left Side: Danh sách bệnh nhân, Bảng chỉ định, Video/Ảnh -->
            <div class="col-md-4">
                <!-- Danh sách bệnh nhân -->
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Danh sách bệnh nhân</h5>
                    </div>
                    <div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-striped table-hover text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Tên bệnh nhân</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patients as $patient)
                                    <tr>
                                        <td>{{ $patient->id }}</td>
                                        <td>{{ $patient->name }}</td>
                                        <td>
                                            <a href="{{ url('examination/ultrasound?patient_id=' . $patient->id) }}"
                                               class="btn btn-sm btn-primary">
                                                Chọn
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Bảng chỉ định -->
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Bảng chỉ định</h5>
                    </div>
                    <div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-striped table-hover text-center mb-0">
                            <thead class="table-dark">
                                <tr id="td_service">
                                    <th>ID</th>
                                    <th>ID dịch vụ</th>
                                    <th>Tên chỉ định</th>
                                </tr>
                            </thead>
                            <tbody id="serviceTable">
                                @if(!empty($services) && count($services) > 0)
                                    @foreach ($services as $service)
                                        <tr data-service-id="{{ $service->examination_service_id }}">
                                            <td>{{ $service->examination_service_id }}</td>
                                            <td>{{ $service->service_id }}</td>
                                            <td class="clickable">{{ $service->name }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-muted">Không có chỉ định nào</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Video/Ảnh Siêu Âm -->
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white text-center">
                        <h5 class="mb-0">🎥/📷 Siêu Âm</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <h6 class="text-success">🎥 Video</h6>
                                <div class="border border-success rounded p-1 mb-2"
                                     style="max-height: 250px; overflow: hidden;">
                                    <video id="video" class="w-100 rounded" controls style="height: 100%;">
                                        <source src="{{ asset('images/mov_bbb.mp4') }}" type="video/mp4">
                                        Trình duyệt của bạn không hỗ trợ thẻ video.
                                    </video>
                                </div>
                                <button type="button" id="captureButton" class="btn btn-primary w-100 btn-sm mb-1">
                                    📸 Chụp Ảnh
                                </button>
                                <input type="text" id="imagePath" class="form-control form-control-sm"
                                       placeholder="Đường dẫn ảnh..." readonly>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-danger">📷 Ảnh Đã Chụp</h6>
                                <div id="imageGrid" class="row row-cols-2 g-1" style="max-height: 250px; overflow-y: auto;">
                                    <!-- Nơi hiển thị ảnh đã chụp -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Thông tin bệnh nhân & Kết quả siêu âm -->
            <div class="col-md-8">
                <!-- Thông tin bệnh nhân -->
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Thông tin bệnh nhân</h5>
                    </div>
                    <div class="card-body">
                        @if($selectedPatientId)
                            @php
                                $selectedPatient = $patients->firstWhere('id', $selectedPatientId);
                            @endphp
                            @if($selectedPatient)
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Tên BN:</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $selectedPatient->name }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Ngày sinh:</label>
                                            <input type="date" class="form-control"
                                                   value="{{ $selectedPatient->date_of_birth }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Tuổi:</label>
                                            <input type="number" class="form-control"
                                                   value="{{ \Carbon\Carbon::parse($selectedPatient->date_of_birth)->age }}"
                                                   readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Giới tính:</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $selectedPatient->gender }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Địa chỉ:</label>
                                            <input type="text" class="form-control"
                                                   value="{{ $selectedPatient->address }}" readonly>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <p class="text-muted">Không tìm thấy thông tin bệnh nhân.</p>
                            @endif
                        @else
                            <p class="text-muted">Chọn một bệnh nhân để xem thông tin.</p>
                        @endif
                    </div>
                </div>

                <!-- Kết quả siêu âm -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">Kết quả siêu âm</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('examination/ultrasound/store') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="txb_service" class="form-label">Chỉ định:</label>
                                <input type="text" id="txb_service" class="form-control form-control-sm" readonly>
                                <input type="hidden" id="examination_service_id" name="examination_service_id"
                                       value="">
                            </div>

                            <div class="mb-3">
                                <label for="templateSelect" class="form-label">Biểu mẫu:</label>
                                <select class="form-select form-select-sm" name="template_id" id="templateSelect">
                                    <option selected>Chọn biểu mẫu</option>
                                    @foreach($templates as $item)
                                        <option value="{{ $item->id }}"
                                                data-content="{{ $item->template_content }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="resultTextarea" class="form-label">Mô tả:</label>
                                <textarea name="result" class="form-control form-control-sm" rows="10"
                                          id="resultTextarea" style="height: 500px;"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="final_result" class="form-label">Kết luận:</label>
                                <textarea name="final_result" class="form-control form-control-sm" rows="3"
                                          id="final_result"></textarea>
                            </div>

                            <input type="hidden" name="captured_images[]" id="hiddenImages">

                            <div class="d-flex justify-content-end">  <!-- Aligns the button to the right -->
                                <button type="submit" class="btn btn-success btn-sm">Lưu kết quả</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <canvas id="canvas" class="d-none"></canvas>

@endsection

    <script>
        function selectPatient(patient) {
            if (!patient) return;
            
            document.getElementById('patient_name').value = patient.name || '';
            document.getElementById('patient_dob').value = patient.date_of_birth || '';
            document.getElementById('patient_age').value = calculateAge(patient.date_of_birth);
            document.getElementById('patient_gender').value = patient.gender || 'Nam';
            document.getElementById('patient_address').value = patient.address || '';
        }

        function calculateAge(dob) {
            if (!dob) return '';
            const birthDate = new Date(dob);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            return age;
        }
        document.addEventListener("DOMContentLoaded", function () {
        // Lấy tất cả ô <td> có thể click trong bảng "Bảng chỉ định"
        document.querySelectorAll("#serviceTable td.clickable").forEach(cell => {
            cell.addEventListener("click", function () {
                document.getElementById("txb_service").value = this.innerText;
                document.getElementById("examination_service_id").value = this.innerText;
            });
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        let templateSelect = document.getElementById("templateSelect");
        let descriptionTextArea = document.querySelector("textarea");

        templateSelect.addEventListener("change", function () {
            let selectedOption = this.options[this.selectedIndex];
            let content = selectedOption.getAttribute("data-content") || "Không có nội dung mẫu.";
            descriptionTextArea.value = content;
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("#serviceTable tr").forEach(row => {
            row.addEventListener("click", function () {
                let serviceId = this.getAttribute("data-service-id");
                let serviceName = this.querySelector("td.clickable").innerText;
                
                document.getElementById("txb_service").value = serviceName;
                document.getElementById("examination_service_id").value = serviceId;
            });
        });

        document.getElementById("templateSelect").addEventListener("change", function () {
            let selectedOption = this.options[this.selectedIndex];
            let content = selectedOption.getAttribute("data-content") || "Không có nội dung mẫu.";
            document.querySelector("textarea[name='result']").value = content;
        });
    });
      // Xử lý khi chọn dịch vụ chỉ định
      document.querySelectorAll("#serviceTable tr").forEach(row => {
            row.addEventListener("click", function () {
                let serviceId = this.getAttribute("data-service-id");
                let serviceName = this.querySelector("td.clickable").innerText;
                
                document.getElementById("txb_service").value = serviceName;
            });
        });

        // Xử lý khi chọn biểu mẫu
        let templateSelect = document.getElementById("templateSelect");
        let descriptionTextArea = document.querySelector("textarea[name='result']");

        templateSelect.addEventListener("change", function () {
            let selectedOption = this.options[this.selectedIndex];
            let content = selectedOption.getAttribute("data-content") || "Không có nội dung mẫu.";
            descriptionTextArea.value = content;
        });
       
        
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const captureButton = document.getElementById("captureButton");
    const imageGrid = document.getElementById("imageGrid");
    const hiddenImagesInput = document.getElementById("hiddenImages");

    captureButton.addEventListener("click", () => {
        if (imageGrid.children.length >= 6) return alert("Chỉ được chụp tối đa 6 ảnh!");

        const ctx = canvas.getContext("2d");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const img = document.createElement("img");
        img.src = canvas.toDataURL("image/png");  
        img.classList.add("img-fluid", "rounded", "border", "border-secondary");

        const colDiv = document.createElement("div");
        colDiv.classList.add("col", "position-relative");

        // Tạo nút xóa ảnh
        const deleteButton = document.createElement("button");
        deleteButton.innerHTML = "❌";
        deleteButton.classList.add("btn", "btn-danger", "btn-sm", "position-absolute", "top-0", "end-0");
        deleteButton.style.transform = "translate(50%, -50%)";

        deleteButton.addEventListener("click", () => {
            colDiv.remove();
            // Cập nhật danh sách ảnh trong input ẩn
            let images = hiddenImagesInput.value ? JSON.parse(hiddenImagesInput.value) : [];
            images = images.filter(src => src !== img.src);
            hiddenImagesInput.value = JSON.stringify(images);
        });

        colDiv.appendChild(img);
        colDiv.appendChild(deleteButton);
        imageGrid.appendChild(colDiv);

        // Cập nhật danh sách ảnh vào input hidden
        let images = hiddenImagesInput.value ? JSON.parse(hiddenImagesInput.value) : [];
        images.push(img.src);
        hiddenImagesInput.value = JSON.stringify(images);
    });
});

    </script>
    