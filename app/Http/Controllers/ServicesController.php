<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;

class ServicesController extends Controller
{
    // Hiển thị danh sách dịch vụ
    public function index()
    {
        $services = Service::all();
        return view('service.index', compact('services'));
    }
    public function store(ServiceRequest $request)
{
    Service::create($request->validated());

    return redirect()->route('service.index')->with('success', 'Dịch vụ đã được thêm thành công.');
}

    // Hiển thị form chỉnh sửa
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('service.edit', compact('service'));
    }

    // Cập nhật thông tin dịch vụ
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->validated());

        return redirect()->route('service.index')->with('success', 'Cập nhật dịch vụ thành công.');
    }

    // Xóa dịch vụ
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('service.index')->with('success', 'Xóa dịch vụ thành công.');
    }
}
