@extends('layouts.layout')

@section('title', 'Khám nội khoa')

@section('content')
    @include('examination.nav')
    @include('inc._success')
    @include('inc._errors')
    <br>

    <div class="container">
        <div class="row">
            <!-- Left Column: Search, Patient List, Patient Info, Services, etc. ( narrower, 5/12 width) -->
            <div class="col-lg-5">
                <!-- Card Tìm kiếm và Lọc -->
                <div class="card shadow border-0 rounded-3 mb-3">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
                        <h5 class="mb-0"><i class="fas fa-search me-2"></i>Tìm kiếm và Lọc</h5>
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="searchCollapse">
                        <div class="card-body">
                            <form action="{{ route('examination.x-ray.index') }}" method="get">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-light"><i class="far fa-calendar-alt"></i></span>
                                            <input type="date" name="start_date" id="start_date" class="form-control" value="2025-01-01" placeholder="Từ ngày">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text bg-light"><i class="far fa-calendar-alt"></i></span>
                                            <input type="date" name="end_date" id="end_date" class="form-control" value="2025-04-03" placeholder="Đến ngày">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                            <i class="fas fa-filter me-2"></i> Lọc
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold"><i class="fas fa-filter me-1"></i>Lọc theo kết quả:</label>
                                        <div class="d-flex">
                                            <div class="form-check me-4">
                                                <input class="form-check-input" type="radio" name="result_filter" id="filterAll" value="all" checked>
                                                <label class="form-check-label" for="filterAll">Tất cả</label>
                                            </div>
                                            <div class="form-check me-4">
                                                <input class="form-check-input" type="radio" name="result_filter" id="filterWithResult" value="with_result">
                                                <label class="form-check-label" for="filterWithResult">Đã có kết quả</label>
                                            </div>
                                            <div class="form-check me-4">
                                                <input class="form-check-input" type="radio" name="result_filter" id="filterWithoutResult" value="without_result">
                                                <label class="form-check-label" for="filterWithoutResult">Chưa có kết quả</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Danh sách bệnh nhân -->
                <div class="card shadow border-0 rounded-3 mb-3">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Danh sách bệnh nhân</h5>
                        <span class="badge bg-light text-primary rounded-pill">{{ $patients->count() }}</span>
                    </div>
                    <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                        <div class="list-group list-group-flush">
                            @php
                                $currentDate = null;
                            @endphp
                            @foreach($patients as $patient)
                                @php
                                    $patientDate = \Carbon\Carbon::parse($patient->created_at)->format('d/m/Y');
                                @endphp
                                @if($patientDate != $currentDate)
                                    <div class="list-group-item bg-light fw-bold text-primary py-1">
                                        <i class="far fa-calendar-alt me-2"></i>Ngày {{ $patientDate }}
                                    </div>
                                    @php $currentDate = $patientDate; @endphp
                                @endif
                                <a href="{{ route('examination.x-ray.index', [
                                    'patient_id' => $patient->id, 
                                    'start_date' => request('start_date'), 
                                    'end_date' => request('end_date'),
                                    'result_filter' => request('result_filter')
                                ]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-2 {{ $selectedPatientId == $patient->id ? 'active' : '' }}">
                                    <div>
                                        <i class="fas fa-user me-2"></i>{{ $patient->name }}
                                    </div>
                                    <span class="btn btn-sm {{ $selectedPatientId == $patient->id ? 'btn-light' : 'btn-primary' }} rounded-pill">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Bảng chỉ định -->
                <div class="card shadow border-0 rounded-3 mb-3">
                    <div class="card-header bg-primary text-white py-2">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Bảng chỉ định</h5>
                    </div>
                    <div class="card-body p-0" style="max-height: 250px; overflow-y: auto;">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-dark">
                                    <tr id="td_service">
                                        <th class="text-center" style="width: 15%">ID</th>
                                        <th class="text-center" style="width: 15%">Mã</th>
                                        <th>Tên chỉ định</th>
                                    </tr>
                                </thead>
                                <tbody id="serviceTable">
                                    @if(!empty($services) && count($services) > 0)
                                        @foreach ($services as $service)
                                            <tr data-service-id="{{ $service->examination_service_id }}" class="cursor-pointer">
                                                <td class="text-center">{{ $service->examination_service_id }}</td>
                                                <td class="text-center">{{ $service->service_id }}</td>
                                                <td class="clickable fw-medium">{{ $service->name }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                <i class="fas fa-info-circle me-2"></i>Không có chỉ định nào
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Thông tin bệnh nhân -->
                <div class="card shadow border-0 rounded-3 mb-3">
                    <div class="card-header bg-primary text-white py-2">
                        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Thông tin bệnh nhân</h5>
                    </div>
                    <div class="card-body">
                        @if($selectedPatientId)
                            @php
                                $selectedPatient = $patients->firstWhere('id', $selectedPatientId);
                            @endphp
                            @if($selectedPatient)
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="patientName" value="{{ $selectedPatient->name }}" readonly>
                                            <label for="patientName"><i class="fas fa-user me-1"></i>Tên BN</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="date" class="form-control" id="patientDob" value="{{ $selectedPatient->date_of_birth }}" readonly>
                                            <label for="patientDob"><i class="fas fa-birthday-cake me-1"></i>Ngày sinh</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="number" class="form-control" id="patientAge" value="{{ \Carbon\Carbon::parse($selectedPatient->date_of_birth)->age }}" readonly>
                                            <label for="patientAge"><i class="fas fa-sort-numeric-up me-1"></i>Tuổi</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="patientGender" value="{{ $selectedPatient->gender }}" readonly>
                                            <label for="patientGender"><i class="fas fa-venus-mars me-1"></i>Giới tính</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="patientAddress" value="{{ $selectedPatient->address }}" readonly>
                                            <label for="patientAddress"><i class="fas fa-map-marker-alt me-1"></i>Địa chỉ</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-user-plus fa-3x mb-3"></i>
                                <p>Vui lòng chọn một bệnh nhân từ danh sách</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Other form fields except description -->
                <div class="card shadow border-0 rounded-3 mb-3">
                    <div class="card-header bg-primary text-white py-2">
                        <h5 class="mb-0"><i class="fas fa-x-ray me-2"></i>Kết quả chụp</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{url('examination/x-ray/store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-clipboard-check me-1"></i>Chỉ định:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-stethoscope"></i></span>
                                    <input type="text" id="txb_service" class="form-control" readonly>
                                    <input type="hidden" id="examination_service_id" name="examination_service_id" value="">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-file-alt me-1"></i>Biểu mẫu:</label>
                                <select class="form-select form-select-lg" name="template_id" id="templateSelect">
                                    <option selected>Chọn biểu mẫu</option>
                                    @foreach($templates as $item)
                                        <option value="{{ $item->id }}" data-content="{{ $item->template_content }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold"><i class="fas fa-file-upload me-1"></i>Tải lên file kết quả:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-file-image"></i></span>
                                    <input type="file" class="form-control" name="file_path">
                                </div>
                            </div>

                   
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save me-2"></i>Lưu
                                </button>
                      

                        </form>
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save me-2"></i>Sửa
                                </button>
                                
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save me-2"></i>In
                                </button>
                    </div>
                </div>
            </div>

            <!-- Right Column: Description Section (wider, 7/12 width) -->
            <div class="col-lg-7">
                <div class="card shadow border-0 rounded-3 h-100">
                    <div class="card-header bg-primary text-white py-2">
                        <h5 class="mb-0"><i class="fas fa-comment-medical me-2"></i>Mô tả</h5>
                    </div>
                    <div class="card-body">
                        <textarea name="result" class="form-control h-100" id="resultTextarea" style="resize: none;"></textarea>
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