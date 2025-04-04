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
                        @forelse($patients as $item)
                            <tr class="table-success">
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm call-btn" 
                                            data-id="{{$item->id}}"
                                            data-name="{{$item->name}}" 
                                            data-dob="{{$item->date_of_birth}}"
                                            data-gender="{{$item->gender}}" 
                                            data-address="{{$item->address}}">
                                        Chọn
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Không có bệnh nhân nào được tiếp nhận hôm nay</td>
                            </tr>
                        @endforelse
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
                         
                                    <input type="hidden" id="exam_id" class="form-control" value = {{$exam_id_med}}>
                           
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

                                                <button type="button" onclick="submitForm('/examination/store-medication')" class="btn btn-primary">
                                                    <i class="fa fa-save" style="color: white;"></i> Lưu toa thuốc
                                                </button>
                                                <a href="{{ route('examination.print_prescription', ['id' => $exam_id_med - 1]) }}">

                                                    <button type="button" id="print-prescription-button" class="btn btn-success">
                                                        In toa thuốc vừa lưu
                                                    </button>
                                                </a>

                                                    
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
                                                <a href="{{ route('examination.print_service', ['id' => $exam_id_ser - 1]) }}">
                                                <button type="button" 
                                                        class="btn btn-primary">In chỉ định vừa lưu
                                                </button>
                                                </a>
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
    $(document).ready(function() {
    // Đọc trạng thái từ localStorage và kích hoạt tab tương ứng khi trang tải lại
    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        $(`#${activeTab}`).tab('show'); // Hiển thị tab đã được lưu
        // Gọi hàm để ẩn hoặc hiển thị các trường liên quan
        if (activeTab === 'lab-test-tab') {
            disableExaminationFields(true); // Ẩn các trường khi tab "Chỉ định cận lâm sàng" được chọn
        } else {
            disableExaminationFields(false); // Hiển thị lại các trường khi tab "Toa thuốc" được chọn
        }
    }

    // Khi nhấn vào tab "Chỉ định cận lâm sàng"
    $('#lab-test-tab').on('click', function() {
        localStorage.setItem('activeTab', 'lab-test-tab'); // Lưu tab hiện tại
        disableExaminationFields(true); // Ẩn các trường không liên quan
    });

    // Khi nhấn vào tab "Toa thuốc"
    $('#prescription-tab').on('click', function() {
        localStorage.setItem('activeTab', 'prescription-tab'); // Lưu tab hiện tại
        disableExaminationFields(false); // Hiển thị lại các trường liên quan
    });

    // Hàm để disable hoặc enable các trường trong phần "Thông tin khám"
    function disableExaminationFields(disable) {
        const fields = [
            'input[name="reason"]', 
            'input[name="symptoms"]', 
            'select[name="diagnosis_id"]', 
            'select[name="doctor_note_id"]'
        ];

        // Ẩn các trường dữ liệu khi "Chỉ định cận lâm sàng" được chọn
        fields.forEach(function(field) {
            if(disable) {
                $(field).closest('.col-md-6').hide();  // Ẩn cả label và input
            } else {
                $(field).closest('.col-md-6').show();  // Hiển thị lại
            }
        });
    }
});

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