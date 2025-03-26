@extends('layouts.layout')

@section('title', 'Cận lâm sàng')

@section('content')
<div class="container mt-4">
    <h2 class="text-center text-primary">Dịch vụ cận lâm sàng</h2>
    @include('inc._success')
    @include('inc._errors')
    @include('modals._add_service')

    <!-- Nút thêm dịch vụ -->
    <a href="" class="btn btn-success rounded-circle position-fixed"
        style="right: 30px; bottom: 30px; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);"
        data-bs-toggle="modal" data-bs-target="#addServiceModal">
        +
    </a>

    <div class="row">
        @php
            $xQuang = $services->where('type', 'X-quang');
            $dienTim = $services->where('type', 'Điện tim');
            $xetNghiem = $services->where('type', 'Xét nghiệm');
            $sieuAm = $services->where('type', 'Siêu âm');
        @endphp

        @foreach (['X-Quang' => $xQuang, 'Điện Tim' => $dienTim, 'Xét Nghiệm' => $xetNghiem, 'Siêu Âm' => $sieuAm] as $type => $servicesList)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-white {{ 
                    $type == 'X-Quang' ? 'bg-primary' : 
                    ($type == 'Điện Tim' ? 'bg-success' : 
                    ($type == 'Xét Nghiệm' ? 'bg-info' : 'bg-warning')) 
                }}">
                    <h5 class="mb-0">{{ $type }}</h5>
                </div>
                <div class="card-body table-responsive" style="max-height: 600px;"> <!-- Tăng chiều cao -->
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Dịch vụ</th>
                                <th>Giá</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servicesList as $key => $service)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ number_format($service->price, 0, ',', '.') }}đ</td>
                                <td>
                                    <!-- Nút Sửa -->
                                    <a href="{{ url('/service/edit/' . $service->id) }}" class="btn btn-warning btn-sm">Sửa</a>

                                    <!-- Nút Xóa -->
                                    <form action="{{ url('service/delete/' . $service->id) }}" method="POST" style="display:inline;" 
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này không?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
