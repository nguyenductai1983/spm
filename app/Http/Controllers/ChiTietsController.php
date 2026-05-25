<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHangHoa;
use App\Enums\TypeNum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChiTietsController extends Controller
{
    public function index(Request $request)
    {
        $query = \Illuminate\Support\Facades\DB::table('IFTs')
            ->leftJoin('chi_tiet_hang_hoas', 'IFTs.ID', '=', 'chi_tiet_hang_hoas.id')
            ->select(
                'IFTs.*', 
                'chi_tiet_hang_hoas.created_by', 
                'chi_tiet_hang_hoas.created_at', 
                'chi_tiet_hang_hoas.last_modified_by', 
                'chi_tiet_hang_hoas.updated_at'
            )
            ->orderBy('IFTs.ID', 'desc');

        // Search filter if any
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('REFNO', 'like', "%{$search}%")
                  ->orWhere('PoNo', 'like', "%{$search}%")
                  ->orWhere('MODEL', 'like', "%{$search}%")
                  ->orWhere('Customer', 'like', "%{$search}%");
            });
        }

        // Aggregate statistics for all unprinted records
        $unprintedCount = \Illuminate\Support\Facades\DB::table('IFTs')->where('usingPrint', 0)->count();
        $totalNumSerial = \Illuminate\Support\Facades\DB::table('IFTs')->where('usingPrint', 0)
            ->get()
            ->sum(function ($item) {
                return is_numeric($item->NumSerial) ? (int)$item->NumSerial : 0;
            });

        $chiTiets = $query->paginate(50)->withQueryString();

        return view('chi_tiets.index', compact('chiTiets', 'unprintedCount', 'totalNumSerial'));
    }

    public function create()
    {
        return view('chi_tiets.create');
    }

    public function store(Request $request)
    {
        // Giữ lại hàm store tạm thời, hoặc chuyển đổi sang ChiTietHangHoa nếu cần.
        // Tuy nhiên theo user bảng chi_tiets sẽ bị xóa nên ta cũng không cần quá lo lắng cho hàm này.
        $request->validate([
            'ref_no' => 'nullable|string|max:100',
            'po_no' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:50',
            'num_serial' => 'nullable|numeric',
        ]);

        $currentUser = Auth::user()->full_name ?? Auth::user()->name;

        ChiTietHangHoa::create(array_merge($request->all(), [
            'using_print' => $request->has('using_print') ? true : false,
            'created_by' => $currentUser,
            'last_modified_by' => $currentUser,
        ]));

        return redirect()->route('chi-tiets.index')->with('success', 'Tạo Shipping Mark mới thành công!');
    }

    public function show(string $id)
    {
        $chiTiet = ChiTietHangHoa::with([
            'thongBaoXuatHang.khachHang',
            'thongBaoXuatHang.hangHoa',
            'containers'
        ])->findOrFail($id);

        return view('chi_tiets.show', compact('chiTiet'));
    }

    public function edit(string $id)
    {
        $chiTiet = ChiTietHangHoa::with([
            'thongBaoXuatHang.khachHang',
            'thongBaoXuatHang.hangHoa',
            'containers'
        ])->findOrFail($id);

        return view('chi_tiets.edit', compact('chiTiet'));
    }

    public function update(Request $request, string $id)
    {
        $chiTiet = ChiTietHangHoa::findOrFail($id);

        $request->validate([
            'model' => 'nullable|string|max:255',
            'size' => 'nullable|string|max:255',
            'nw' => 'nullable|string|max:255',
            'gw' => 'nullable|string|max:255',
            'dai' => 'nullable|numeric',
            'rong' => 'nullable|numeric',
            'cao' => 'nullable|numeric',
            'color' => 'nullable|string|max:255',
            'selected_type_num' => 'nullable|integer',
            'type_suffix' => 'nullable|string',
            'lot_no' => 'nullable|string|max:255',
            'quantity' => 'nullable|string|max:255',
            'start_serial' => 'nullable|string|max:255',
            'num_serial' => 'nullable|integer|min:0',
        ]);

        $currentUser = Auth::user()->full_name ?? Auth::user()->name;

        $chiTiet->update([
            'model' => $request->model,
            'size' => $request->size,
            'nw' => $request->nw,
            'gw' => $request->gw,
            'dai' => $request->dai,
            'rong' => $request->rong,
            'cao' => $request->cao,
            'color' => $request->color,
            'selected_type_num' => $request->input('selected_type_num', $chiTiet->selected_type_num?->value ?? 0),
            'extended_content' => $request->type_suffix,
            'lot_no' => $request->lot_no,
            'quantity' => $request->quantity,
            'using_print' => $request->has('using_print') ? true : false,
            'last_modified_by' => $currentUser,
        ]);

        $tu = $request->start_serial;
        $soLuong = $request->num_serial;
        $den = (is_numeric($tu) && is_numeric($soLuong)) ? ((int)$tu + (int)$soLuong - 1) : $tu;

        $container = $chiTiet->containers()->first();
        if ($container) {
            $container->update([
                'tu' => $tu,
                'so_luong' => $soLuong,
                'den' => $den,
            ]);
        } else {
            if ($tu !== null || $soLuong !== null) {
                $chiTiet->containers()->create([
                    'thong_bao_xuat_hang_id' => $chiTiet->thong_bao_xuat_hang_id,
                    'tu' => $tu,
                    'so_luong' => $soLuong,
                    'den' => $den,
                ]);
            }
        }

        // Cập nhật lại thời gian (updated_at) phòng trường hợp chỉ có dữ liệu Container thay đổi
        $chiTiet->touch();

        return redirect()->route('chi-tiets.index')->with('success', 'Cập nhật Shipping Mark thành công!');
    }

    public function destroy(string $id)
    {
        $chiTiet = ChiTietHangHoa::findOrFail($id);
        $chiTiet->delete();

        return redirect()->route('chi-tiets.index')->with('success', 'Đã xóa Shipping Mark thành công!');
    }

    public function confirmPrint(string $id)
    {
        $chiTiet = ChiTietHangHoa::findOrFail($id);
        
        $currentUser = Auth::user()->full_name ?? Auth::user()->name;

        $chiTiet->update([
            'using_print' => true,
            'last_modified_by' => $currentUser,
        ]);

        return back()->with('success', 'Đã xác nhận in thành công!');
    }
}
