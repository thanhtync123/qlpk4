@extends('layouts.layout')

@section('title', 'Khám nội khoa')

@section('content')
    @include('examination.nav')
    @include('inc._success')
    @include('inc._errors')

    <div class="d-flex justify-content-center align-items-start flex-grow-1">
        <div class="container-fluid mt-4" style="max-width: 960px;">
            <div class="row">
                <!-- Danh sách phiếu -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">Danh sách bệnh nhân</h5>
                        </div>
                        <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
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
                                            <a href="{{ url('examination/x-ray?patient_id=' . $patient->id) }}" 
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

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">Bảng chỉ định</h5>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-hover text-center mb-0">
                                <thead class="table-dark">
                                    <tr id="td_service">
                                        <th>ID từ bảng chỉ định quăng qua </th>
                                        <th>ID</th>
                                        <th>Tên chỉ định</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceTable">
                                    @if(!empty($services) && count($services) > 0)
                                        @foreach ($services as $service)
                                            <tr data-service-id="{{ $service->examination_service_id }}">
                                                <td>{{ $service->examination_service_id }}</td> <!-- Đây là examination_services.id -->
                                                <td>{{ $service->service_id }}</td> <!-- Đây là services.id -->
                                                <td class="clickable">{{ $service->name }}</td> <!-- Đây là services.name -->
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
                </div>

                <!-- Thông tin bệnh nhân -->
                <div class="col-md-8">
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
                                                       value="{{ \Carbon\Carbon::parse($selectedPatient->date_of_birth)->age }}" readonly>
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
                                @endif
                            @else
                                <p class="text-muted">Chọn một bệnh nhân để xem thông tin.</p>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="mb-0">Kết quả chụp</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{url('examination/x-ray/store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                               
                                <div class="mb-3">
                                    <label class="form-label">Chỉ định:</label>
                                    <input type="text" id="txb_service" class="form-control" readonly>
                                    <input type="text" id="examination_service_id" name="examination_service_id"value="">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Biểu mẫu:</label>
                                    <select class="form-select" name="template_id" id="templateSelect">
                                        <option selected>Chọn biểu mẫu</option>
                                        @foreach($templates as $item)
                                            <option value="{{ $item->id }}" data-content="{{ $item->template_content }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mô tả:</label>
                                    <textarea name="result" class="form-control" rows="4" id="resultTextarea" ></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tải lên file kết quả:</label>
                                    <input type="file" class="form-control" name="file_path">
                                </div>

                                <button type="submit" class="btn btn-success">Lưu kết quả</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
