<?php

namespace App\Http\Controllers;

use App\Models\HangHoa;
use Illuminate\Http\Request;

class HangHoaController extends Controller
{
    public function index()
    {
        $hangHoas = HangHoa::orderBy('code')->get();
        return view('hang_hoas.index', compact('hangHoas'));
    }

    public function create()
    {
        return view('hang_hoas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:hang_hoas,code',
            'name' => 'required|string|max:255',
        ], [
            'code.required' => 'Mã hàng hóa không được để trống.',
            'code.unique' => 'Mã hàng hóa đã tồn tại.',
            'name.required' => 'Tên hàng hóa không được để trống.',
        ]);

        HangHoa::create($request->all());

        return redirect()->route('hang-hoas.index')->with('success', 'Thêm hàng hóa mới thành công!');
    }

    public function edit(string $id)
    {
        $hangHoa = HangHoa::findOrFail($id);
        return view('hang_hoas.edit', compact('hangHoa'));
    }

    public function update(Request $request, string $id)
    {
        $hangHoa = HangHoa::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:hang_hoas,code,' . $hangHoa->id,
            'name' => 'required|string|max:255',
        ], [
            'code.required' => 'Mã hàng hóa không được để trống.',
            'code.unique' => 'Mã hàng hóa đã được sử dụng.',
            'name.required' => 'Tên hàng hóa không được để trống.',
        ]);

        $hangHoa->update($request->all());

        return redirect()->route('hang-hoas.index')->with('success', 'Cập nhật thông tin hàng hóa thành công!');
    }

    public function destroy(string $id)
    {
        $hangHoa = HangHoa::findOrFail($id);

        if ($hangHoa->thongBaoXuatHangs()->count() > 0) {
            return back()->with('error', 'Không thể xóa hàng hóa này vì đang có phiếu thông báo xuất hàng liên quan.');
        }

        $hangHoa->delete();

        return redirect()->route('hang-hoas.index')->with('success', 'Đã xóa hàng hóa thành công!');
    }
}
