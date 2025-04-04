@extends('layouts.layout')

@section('title', 'Khám nội khoa')

@section('content')

    @include('inc._success')
    @include('inc._errors')

    <div class="container-fluid p-3">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 border-end">
                <h4 class="mb-3">Danh sách bệnh nhân</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tên bệnh nhân</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($patients as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm call-btn" data-id="{{$item->id}}"
                                            data-name="{{$item->name}}" data-dob="{{$item->date_of_birth}}"
                                            data-gender="{{$item->gender}}" data-address="{{$item->address}}">Chọn
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <h4 class="mb-3">Thông tin khám bệnh</h4>
                <form method="POST" id="myForm">
                    @csrf
                    <input type="hidden" name="patient_id" id="patient-id" class="form-control">
                    <div class="card mb-3">
                        <div class="card-header bg-light">Thông tin bệnh nhân</div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">Họ và Tên:</label>
                                    <input type="text" id="patient-name" class="form-control" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Ngày sinh:</label>
                                    <input type="date" id="patient-dob" class="form-control" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Tuổi:</label>
                                    <input type="text" id="patient-age" class="form-control" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Giới tính:</label>
                                    <input type="text" id="patient-gender" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <label class="form-label">Địa chỉ:</label>
                                    <input type="text" id="patient-address" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card mb-3">
                        <div class="card-header bg-light">Thông tin khám</div>
                        <div class="card-body">
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <label class="form-label">Lý do khám:</label>
                                    <input type="text" name="reason" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Triệu chứng:</label>
                                    <input type="text" name="symptoms" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Chẩn đoán:</label>
                                    <select name="diagnosis_id" class="form-control">
                                        @foreach($diagnoses as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Lời dặn:</label>
                                    <select name="doctor_note_id" class="form-control">
                                        @foreach($doctor_notes as $item)
                                            <option value="{{$item->id}}">{{$item->content}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <ul class="nav nav-tabs mt-3" id="tabMenu">
                        <li class="nav-item">
                            <a class="nav-link active" id="prescription-tab" data-bs-toggle="tab"
                               href="#prescription">Toa thuốc</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="lab-test-tab" data-bs-toggle="tab" href="#lab-test">Chỉ định cận
                                lâm sàng</a>
                        </li>
                    </ul>

                    <div class="tab-content mt-2">
                        <!-- Toa thuốc -->
                        <div class="tab-pane fade show active" id="prescription">
                            <div class="card">
                                <div class="card-header bg-light">Toa thuốc</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="prescription-table">
                                            <thead>
                                            <tr>
                                                <th>Tên thuốc</th>
                                                <th>Đơn vị</th>
                                                <th>Liều dùng</th>
                                                <th>Đường dùng</th>
                                                <th>Số lần/ngày</th>
                                                <th>Ghi chú</th>
                                                <th>Số lượng</th>
                                                <th>Giá tiền/đv</th>
                                                <th>Thành tiền</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="prescription-rows">
                                            <tr>
                                                <td>
                                                    <select name="medications[0][id]"
                                                            class="form-control medication-select"
                                                            onchange="fillMedication(this);">
                                                        <option value="">Chọn thuốc</option>
                                                        @foreach($medications as $med)
                                                            <option value="{{ $med->id }}"
                                                                    data-unit="{{ $med->unit }}"
                                                                    data-dosage="{{ $med->dosage }}"
                                                                    data-route="{{ $med->route }}"
                                                                    data-times="{{ $med->times_per_day }}"
                                                                    data-note="{{ $med->note }}"
                                                                    data-price="{{ $med->price }}">
                                                                {{ $med->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="text" name="medications[0][unit]"
                                                           class="form-control unit" readonly></td>
                                                <td><input type="text" name="medications[0][dosage]"
                                                           class="form-control dosage"></td>
                                                <td><input type="text" name="medications[0][route]"
                                                           class="form-control route"></td>
                                                <td><input type="text" name="medications[0][times]"
                                                           class="form-control times"></td>
                                                <td><input type="text" name="medications[0][note]"
                                                           class="form-control note"></td>
                                                <td><input type="number" name="medications[0][quantity]"
                                                           class="form-control quantity" value="1" min="1"
                                                           onchange="updateRowPrice(this)"></td>
                                                <td><input type="number" name="medications[0][unit_price]"
                                                           class="form-control unit_price" readonly></td>
                                                <td><input type="number" name="medications[0][total_price]"
                                                           class="form-control total_price" readonly></td>

                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="removeRow(this)">
                                                        Xóa
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>

                                            <tfoot>
                                            <tr>
                                                <td colspan="10">
                                                    <button type="button" class="btn btn-success btn-sm w-100"
                                                            onclick="addRow()">+ Thêm thuốc
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8"></td>
                                                <td><strong>Tổng tiền thuốc:</strong></td>
                                                <td id="total-medication-price">0 VND</td>
                                            </tr>
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <button type="button"
                                                            onclick="submitForm('/examination/store-medication')"
                                                            class="btn btn-primary">Lưu toa thuốc
                                                    </button>
                                                    <button type="button" id="print-prescription-button" onclick="printdonthuoc()"  class="btn btn-primary">In toa thuốc</button>
                                                    
                                                </td>
                                            </tr>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Chỉ định cận lâm sàng -->
                        <div class="tab-pane fade" id="lab-test">
                            <div class="card">
                                <div class="card-header bg-light">Chỉ định cận lâm sàng</div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="serviceType" class="form-label">Loại dịch vụ:</label>
                                        <select name="service_type" class="form-control" id="serviceType"
                                                onchange="filterServices()">
                                            <option value="">Tất cả</option>
                                            <option value="X-quang">X-quang</option>
                                            <option value="Điện tim">Điện tim</option>
                                            <option value="Xét nghiệm">Xét nghiệm</option>
                                            <option value="Siêu âm">Siêu âm</option>
                                        </select>
                                    </div>

                                    <h5>Danh sách chỉ định</h5>
                                    <div class="table-responsive">
                                        <div style="max-height: 300px; overflow-y: auto;">
                                            <!-- Overflow container -->
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="w-50">Tên chỉ định</th>
                                                    <th class="w-25">Giá tiền</th>
                                                    <th class="w-25">Chọn</th>
                                                </tr>
                                                </thead>
                                                <tbody id="lab-tests">
                                                @foreach($services as $item)
                                                    <tr class="service-row" data-type="{{ $item->type }}">
                                                        <td class="w-50">{{ $item->name }}</td>
                                                        <td class="w-25">{{ number_format($item->price, 0, ',', '.') }}
                                                            VND
                                                        </td>
                                                        <td class="w-25">
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                    onclick="addTest('{{ $item->name }}', {{ $item->price }})">
                                                                Thêm
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <h5>Chỉ định đã chọn</h5>
                                    <table class="table table-bordered" id="selected-items-table">
                                        <thead>
                                        <tr>
                                            <th>Tên</th>
                                            <th>Giá tiền</th>
                                            <th>Xóa</th>
                                        </tr>
                                        </thead>
                                        <tbody id="selected-items">
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td><strong>Tổng tiền</strong></td>
                                            <td id="total-price">0 VND</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-center">
                                                <button type="button" onclick="submitForm('/examination/store-service')"
                                                        class="btn btn-primary">Lưu chỉ định
                                                </button>
                                            </td>
                                        </tr>

                                        </tfoot>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>

<script>
    function submitForm(url) {
        var formData = $('#myForm').serialize();  // Serialize toàn bộ form để gửi đi
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        success: function(response) {
            if(response.success) {
                alert('Toa thuốc đã được lưu thành công.');
                
            } else {
                alert('Có lỗi khi lưu toa thuốc.');
            }
        },
        error: function() {
            alert('Lỗi kết nối, vui lòng thử lại.');
        }
    });
    }

    
   


function printdonthuoc() {
    // Lấy thông tin bệnh nhân
    var patientName = $('#patient-name').val();
    var patientDob = $('#patient-dob').val();
    var patientGender = $('#patient-gender').val();
    var patientAddress = $('#patient-address').val();

    // Lấy thông tin khám bệnh
    var reason = $('input[name="reason"]').val();
    var symptoms = $('input[name="symptoms"]').val();
    var diagnosis = $('select[name="diagnosis_id"] option:selected').text();
    var doctorNote = $('select[name="doctor_note_id"] option:selected').text();

    // Lấy danh sách thuốc
    var medications = [];
    $('#prescription-rows tr').each(function() {
        var medication = {
            name: $(this).find('.medication-select option:selected').text(),
            unit: $(this).find('.unit').val(),
            dosage: $(this).find('.dosage').val(),
            route: $(this).find('.route').val(),
            times: $(this).find('.times').val(),
            note: $(this).find('.note').val(),
            quantity: $(this).find('.quantity').val(),
            unitPrice: $(this).find('.unit_price').val(),
            totalPrice: $(this).find('.total_price').val()
        };
        medications.push(medication);
    });

    // Tạo HTML cho hóa đơn
    var html = '<h1>Hóa đơn toa thuốc</h1>';
    html += '<p><strong>Tên bệnh nhân:</strong> ' + patientName + '</p>';
    html += '<p><strong>Ngày sinh:</strong> ' + patientDob + '</p>';
    html += '<p><strong>Giới tính:</strong> ' + patientGender + '</p>';
    html += '<p><strong>Địa chỉ:</strong> ' + patientAddress + '</p>';
    html += '<p><strong>Lý do khám:</strong> ' + reason + '</p>';
    html += '<p><strong>Triệu chứng:</strong> ' + symptoms + '</p>';
    html += '<p><strong>Chẩn đoán:</strong> ' + diagnosis + '</p>';
    html += '<p><strong>Lời dặn:</strong> ' + doctorNote + '</p>';

    html += '<h3>Danh sách thuốc</h3>';
    html += '<table border="1" style="width:100%; border-collapse: collapse;">';
    html += '<tr><th>Tên thuốc</th><th>Đơn vị</th><th>Liều dùng</th><th>Đường dùng</th><th>Số lần/ngày</th><th>Ghi chú</th><th>Số lượng</th><th>Giá tiền/đv</th><th>Thành tiền</th></tr>';
    medications.forEach(function(med) {
        html += '<tr>';
        html += '<td>' + med.name + '</td>';
        html += '<td>' + med.unit + '</td>';
        html += '<td>' + med.dosage + '</td>';
        html += '<td>' + med.route + '</td>';
        html += '<td>' + med.times + '</td>';
        html += '<td>' + med.note + '</td>';
        html += '<td>' + med.quantity + '</td>';
        html += '<td>' + med.unitPrice + ' VND</td>';
        html += '<td>' + med.totalPrice + ' VND</td>';
        html += '</tr>';
    });
    html += '</table>';

    // Mở cửa sổ in
    var popupWin = window.open('', '_blank', 'width=800,height=600');
    popupWin.document.open();
    popupWin.document.write('<html><head><title>In toa thuốc</title></head><body>' + html + '</body></html>');
    popupWin.document.close();
    popupWin.print();
}
</script>
   <script>


        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".call-btn").forEach(button => {
                button.addEventListener("click", function () {
                    // Thêm patient_id ẩn
                    document.getElementById("patient-id").value = this.dataset.id;

                    document.getElementById("patient-name").value = this.dataset.name;
                    document.getElementById("patient-dob").value = this.dataset.dob;
                    document.getElementById("patient-gender").value = this.dataset.gender;
                    document.getElementById("patient-address").value = this.dataset.address;

                    let dob = new Date(this.dataset.dob);
                    let today = new Date();
                    let age = today.getFullYear() - dob.getFullYear();
                    let monthDiff = today.getMonth() - dob.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                        age--;
                    }
                    document.getElementById("patient-age").value = age;
                });
            });

            window.submitForm = function (action) {
                let form = document.getElementById('myForm');
                if (form) {
                    form.action = action;
                    form.submit();
                } else {
                    console.error("Form with ID 'myForm' not found!");
                }
            };
        });


        let totalPrice = 0;

        function fillMedication(select) {
            const row = select.closest('tr');
            const selectedOption = select.options[select.selectedIndex];
            const unitPrice = parseFloat(selectedOption.dataset.price) || 0;

            row.querySelector('.unit').value = selectedOption.dataset.unit || '';
            row.querySelector('.dosage').value = selectedOption.dataset.dosage || '';
            row.querySelector('.route').value = selectedOption.dataset.route || '';
            row.querySelector('.times').value = selectedOption.dataset.times || '';
            row.querySelector('.note').value = selectedOption.dataset.note || '';
            row.querySelector('.unit_price').value = unitPrice; // Điền giá tiền/đv
            row.querySelector('.quantity').value = 1; // Reset số lượng về 1 khi chọn thuốc mới

            updateRowPrice(row.querySelector('.quantity')); // Cập nhật giá tiền theo số lượng
        }

        function updateMedicationInputNames() {
            const rows = document.querySelectorAll('#prescription-rows tr');
            rows.forEach((row, index) => {
                row.querySelector('select[name^="medications"]').setAttribute('name', `medications[${index}][id]`);
                row.querySelector('.unit').setAttribute('name', `medications[${index}][unit]`);
                row.querySelector('.dosage').setAttribute('name', `medications[${index}][dosage]`);
                row.querySelector('.route').setAttribute('name', `medications[${index}][route]`);
                row.querySelector('.times').setAttribute('name', `medications[${index}][times]`);
                row.querySelector('.note').setAttribute('name', `medications[${index}][note]`);
                row.querySelector('.quantity').setAttribute('name', `medications[${index}][quantity]`);
                row.querySelector('.unit_price').setAttribute('name', `medications[${index}][unit_price]`);
                row.querySelector('.total_price').setAttribute('name', `medications[${index}][total_price]`);
            });
        }

        function calculateTotalPrice() {
            let totalPrice = 0;
            const priceInputs = document.querySelectorAll('.total_price');
            priceInputs.forEach(input => {
                const price = parseFloat(input.value) || 0;
                totalPrice += price;
            });
            return totalPrice;
        }

        function updateTotalMedicationPrice() {
            const totalPrice = calculateTotalPrice();
            document.getElementById('total-medication-price').textContent = `${totalPrice.toLocaleString('vi-VN')} VND`;
        }

        function addRow() {
            const tbody = document.getElementById('prescription-rows');
            const newRow = tbody.querySelector('tr').cloneNode(true);

            newRow.querySelector('select').value = '';
            newRow.querySelector('.unit').value = '';
            newRow.querySelector('.dosage').value = '';
            newRow.querySelector('.route').value = '';
            newRow.querySelector('.times').value = '';
            newRow.querySelector('.note').value = '';
            newRow.querySelector('.quantity').value = 1;
            newRow.querySelector('.unit_price').value = '';
            newRow.querySelector('.total_price').value = '';


            tbody.appendChild(newRow);
            updateMedicationInputNames();
        }

        function removeRow(button) {
            const tbody = document.getElementById('prescription-rows');
            if (tbody.children.length > 1) {
                button.closest('tr').remove();
                updateMedicationInputNames();
                updateTotalMedicationPrice();
            }
        }

        function filterServices() {
            const selectedType = document.getElementById('serviceType').value;
            const rows = document.getElementsByClassName('service-row');

            for (let row of rows) {
                const rowType = row.getAttribute('data-type');
                if (selectedType === '' || rowType === selectedType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        function addTest(name, price) {
            const tbody = document.getElementById('selected-items');
            const row = document.createElement('tr');

            const serviceData = {
                name: name,
                price: price
            };
            const serviceJson = JSON.stringify(serviceData);

            row.innerHTML = `
                <td>${name}</td>
                <td>${price.toLocaleString('vi-VN')} VND</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this, ${price})">Xóa</button>
                    <input type="hidden" name="selected_services[]" value='${serviceJson}'>
                </td>
            `;

            tbody.appendChild(row);
            updateTotalPrice(price, 'add');
        }

        function removeItem(button, price) {
            button.closest('tr').remove();
            updateTotalPrice(price, 'remove');
        }

        function updateTotalPrice(price, action) {
            if (action === 'add') {
                totalPrice += price;
            } else if (action === 'remove') {
                totalPrice -= price;
            }
            document.getElementById('total-price').textContent = `${totalPrice.toLocaleString('vi-VN')} VND`;
        }

        function updateRowPrice(quantityInput) {
            const row = quantityInput.closest('tr');
            const quantity = parseInt(quantityInput.value) || 0;
            const unitPrice = parseFloat(row.querySelector('.unit_price').value) || 0;
            const totalPrice = quantity * unitPrice;

            row.querySelector('.total_price').value = totalPrice;
            updateTotalMedicationPrice();
        }


    </script>

@endsection