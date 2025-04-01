@extends('layouts.layout')

@section('title', 'Xét nghiệm')

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
                                            <a href="{{ url('examination/test?patient_id=' . $patient->id) }}" 
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
                            <form action="{{url('examination/test/store')}}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label">Kết quả xét nghiệm:</label>
                                    <textarea name="result" class="form-control" rows="4" id="resultTextarea" ></textarea>
                                    <div class="container mt-3">
                                    <h3 class="mb-3">Danh sách kết quả xét nghiệm</h3>
                                    <table class="table table-bordered table-striped">
                                        <thead class="table-primary text-center">
                                            <tr>
                                                <th>Tên xét nghiệm</th>
                                                <th>Tên kết quả</th>
                                                <th>Kết quả</th>
                                                <th>Đơn vị</th>
                                                <th>Chỉ số đơn vị</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                    
                                    </table>
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
<script>document.addEventListener("DOMContentLoaded", function () {
    // Khai báo các biến DOM cần dùng
    const templateSelect = document.getElementById("templateSelect");
    const resultTextarea = document.getElementById("resultTextarea");
    const tableContainer = document.querySelector(".container.mt-3 table");

    function selectPatient(patient) {
        if (!patient) return;
        const fields = {
            patient_name: patient.name || '',
            patient_dob: patient.date_of_birth || '',
            patient_age: calculateAge(patient.date_of_birth),
            patient_gender: patient.gender || 'Nam',
            patient_address: patient.address || ''
        };
        Object.keys(fields).forEach(id => document.getElementById(id).value = fields[id]);
    }

    function calculateAge(dob) {
        if (!dob) return '';
        const birthDate = new Date(dob), today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        if (today.getMonth() < birthDate.getMonth() || 
            (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
            age--;
        }
        return age;
    }

    // Xử lý khi click vào bảng chỉ định
    document.querySelectorAll("#serviceTable td.clickable, #serviceTable tr").forEach(el => {
        el.addEventListener("click", function () {
            let serviceName = this.closest("tr").querySelector("td.clickable")?.innerText || '';
            let serviceId = this.closest("tr").getAttribute("data-service-id") || serviceName;
            document.getElementById("txb_service").value = serviceName;
            document.getElementById("examination_service_id").value = serviceId;
        });
    });

    // Hiển thị bảng dựa trên dữ liệu JSON từ textarea
    function renderTable(data) {
        if (!tableContainer) return;
    
        tableContainer.innerHTML = `
            <thead class="table-primary text-center">
                <tr>
                    <th>Tên xét nghiệm</th>
                    <th>Tên kết quả</th>
                    <th>Kết quả</th>
                    <th>Đơn vị</th>
                    <th>Chỉ số đơn vị</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody></tbody>
        `;
        
        const tbody = tableContainer.querySelector("tbody");

        if (!data || !data.tests || !Array.isArray(data.tests)) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center">Dữ liệu JSON không hợp lệ!</td></tr>`;
            return;
        }

        data.tests.forEach(test => {
            let firstRow = true;
            test.results.forEach((result, resultIndex) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    ${firstRow ? `<td rowspan="${test.results.length}">${test.name || ''}</td>` : ''}
                    <td>${result.name || ''}</td>
                    <td><input type="text" class="form-control" data-test-index="${data.tests.indexOf(test)}" data-result-index="${resultIndex}" data-field="value" value="${result.value || ''}"></td>
                 <td><input type="text" class="form-control" data-test-index="${data.tests.indexOf(test)}" data-result-index="${resultIndex}" data-field="unit" value="${result.unit || ''}"></td>
<td><input type="text" class="form-control" data-test-index="${data.tests.indexOf(test)}" data-result-index="${resultIndex}" data-field="range" value="${result.range || ''}"></td>
<td><input type="text" class="form-control" data-test-index="${data.tests.indexOf(test)}" data-result-index="${resultIndex}" data-field="note" value="${result.note || ''}"></td>

                `;
                tbody.appendChild(row);
                firstRow = false;
            });
        });

        // Gắn sự kiện input cho các ô nhập liệu
        attachInputListeners();
    }

    function updateJSONFromTable() {
    if (!resultTextarea) return;
    
    let data;
    try {
        data = JSON.parse(resultTextarea.value || '{}');
        if (!data.tests) data.tests = [];
    } catch (error) {
        console.error("Lỗi khi phân tích JSON:", error);
        data = { tests: [] };
    }

    // Cập nhật dữ liệu từ bảng vào JSON
    document.querySelectorAll("tbody input").forEach(input => {
        const testIndex = parseInt(input.getAttribute("data-test-index"));
        const resultIndex = parseInt(input.getAttribute("data-result-index"));
        const field = input.getAttribute("data-field");

        if (!isNaN(testIndex) && !isNaN(resultIndex) &&
            data.tests[testIndex] &&
            data.tests[testIndex].results &&
            data.tests[testIndex].results[resultIndex]) {

            // Cập nhật giá trị cho field tương ứng
            data.tests[testIndex].results[resultIndex][field] = input.value;
        }
    });

    // Cập nhật lại textarea với dữ liệu JSON mới
    resultTextarea.value = JSON.stringify(data, null, 2);
}


    // Gắn sự kiện input cho các ô trong bảng
    function attachInputListeners() {
        document.querySelectorAll("tbody input").forEach(input => {
            input.removeEventListener("input", updateJSONFromTable); // Xóa sự kiện cũ để tránh lặp
            input.addEventListener("input", updateJSONFromTable); // Gắn sự kiện mới
        });
    }

    // Xử lý khi chọn template
    function handleTemplateChange() {
        if (!templateSelect || !resultTextarea) return;
        
        const content = templateSelect.selectedOptions[0]?.getAttribute("data-content") || "{}";
        resultTextarea.value = content;
        try {
            const data = JSON.parse(content);
            renderTable(data);
        } catch (error) {
            console.error("Lỗi khi phân tích JSON từ template:", error);
            if (tableContainer) {
                const tbody = tableContainer.querySelector("tbody") || tableContainer;
                tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center">Dữ liệu JSON không hợp lệ!</td></tr>`;
            }
        }
    }

    // Xử lý khi người dùng sửa trực tiếp textarea
    function handleTextareaChange() {
        if (!resultTextarea) return;
        
        try {
            const data = JSON.parse(resultTextarea.value || '{}');
            renderTable(data);
        } catch (error) {
            console.error("Lỗi khi phân tích JSON từ textarea:", error);
            if (tableContainer) {
                const tbody = tableContainer.querySelector("tbody") || tableContainer;
                tbody.innerHTML = `<tr><td colspan="6" class="text-danger text-center">Dữ liệu JSON không hợp lệ!</td></tr>`;
            }
        }
    }
    if (templateSelect) {
        templateSelect.addEventListener("change", handleTemplateChange);
    }
    if (resultTextarea) {
        resultTextarea.addEventListener("input", handleTextareaChange);
    }
    if (resultTextarea && resultTextarea.value) {
        handleTextareaChange();
    }
});

</script>