<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function index()
    {
        $khachHangs = KhachHang::orderBy('code')->get();
        return view('khach_hangs.index', compact('khachHangs'));
    }

    public function create()
    {
        return view('khach_hangs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:khach_hangs,code',
            'name' => 'required|string|max:255',
        ], [
            'code.required' => 'Mã khách hàng không được để trống.',
            'code.unique' => 'Mã khách hàng đã tồn tại.',
            'name.required' => 'Tên khách hàng không được để trống.',
        ]);

        KhachHang::create($request->all());

        return redirect()->route('khach-hangs.index')->with('success', 'Thêm khách hàng mới thành công!');
    }

    public function edit($id)
    {
        $khachHang = KhachHang::findOrFail($id);
        return view('khach_hangs.edit', compact('khachHang'));
    }

    public function update(Request $request, $id)
    {
        $khachHang = KhachHang::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:khach_hangs,code,' . $khachHang->id,
            'name' => 'required|string|max:255',
        ], [
            'code.required' => 'Mã khách hàng không được để trống.',
            'code.unique' => 'Mã khách hàng đã được sử dụng.',
            'name.required' => 'Tên khách hàng không được để trống.',
        ]);

        $khachHang->update($request->all());

        return redirect()->route('khach-hangs.index')->with('success', 'Cập nhật thông tin khách hàng thành công!');
    }

    public function destroy($id)
    {
        $khachHang = KhachHang::findOrFail($id);
        
        // Check if there are associated shipping marks
        if ($khachHang->thongBaoXuatHangs()->count() > 0) {
            return back()->with('error', 'Không thể xóa khách hàng này vì đang có phiếu thông báo xuất hàng liên quan.');
        }

        $khachHang->delete();

        return redirect()->route('khach-hangs.index')->with('success', 'Đã xóa khách hàng thành công!');
    }
}
