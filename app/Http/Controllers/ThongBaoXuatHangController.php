<?php

namespace App\Http\Controllers;

use App\Models\ThongBaoXuatHang;
use App\Models\ChiTietHangHoa;
use App\Models\Container;
use App\Models\KhachHang;
use App\Models\HangHoa;
use App\Enums\TypeNum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ThongBaoXuatHangController extends Controller
{
    public function index()
    {
        $thongBaoList = ThongBaoXuatHang::with('khachHang')
            ->orderBy('id', 'desc')
            ->get();

        return view('thong_bao_xuat_hang.index', compact('thongBaoList'));
    }

    public function show($id)
    {
        $thongBao = ThongBaoXuatHang::with([
            'khachHang',
            'hangHoa',
            'chiTietHangHoas',
            'containers.chiTietHangHoa'
        ])->findOrFail($id);

        return view('thong_bao_xuat_hang.show', compact('thongBao'));
    }

    public function quickCreate()
    {
        $khachHangs = KhachHang::orderBy('name')->get();
        $hangHoas = HangHoa::orderBy('name')->get();
        
        // Return view with empty model to share the edit form
        $thongBao = new ThongBaoXuatHang();
        $thongBao->ngay_du_kien = now();
        $thongBao->ngay_etd = now();

        return view('thong_bao_xuat_hang.quick_create', compact('khachHangs', 'hangHoas', 'thongBao'));
    }

    public function storeQuickCreate(Request $request)
    {
        $request->validate([
            'khach_hang_id' => 'required|exists:khach_hangs,id',
            'hang_hoa_id' => 'required|exists:hang_hoas,id',
            'loai_hang' => 'required|string|max:255',
            'so_luong' => 'required|integer|min:0',
            'ref_no' => 'required|string|max:255',
            'po_no' => 'required|string|max:255',
            'ngay_du_kien' => 'required|date',
            'ngay_etd' => 'required|date',
            'ghi_chu' => 'nullable|string',
        ]);

        $currentUser = Auth::user()->full_name ?? Auth::user()->name;

        DB::beginTransaction();
        try {
            $thongBao = ThongBaoXuatHang::create([
                'khach_hang_id' => $request->khach_hang_id,
                'hang_hoa_id' => $request->hang_hoa_id,
                'loai_hang' => $request->loai_hang,
                'so_luong' => $request->so_luong,
                'ref_no' => $request->ref_no,
                'po_no' => $request->po_no,
                'ngay_du_kien' => $request->ngay_du_kien,
                'ngay_etd' => $request->ngay_etd,
                'ghi_chu' => $request->ghi_chu,
                'created_by' => Auth::id(),
                'last_modified_by' => Auth::id(),
            ]);

            if ($request->has('ChiTietList')) {
                foreach ($request->ChiTietList as $item) {
                    // Check if model name is empty
                    if (empty($item['MODEL'])) {
                        continue;
                    }

                    ChiTietHangHoa::create([
                        'thong_bao_xuat_hang_id' => $thongBao->id,
                        'model' => $item['MODEL'] ?? null,
                        'size' => $item['SIZE'] ?? null,
                        'so_luong_tham_khao' => is_numeric($item['SoLuongThamKhao'] ?? null) ? (int)$item['SoLuongThamKhao'] : 0,
                        'selected_type_num' => isset($item['SelectedTypeNum']) ? (int)$item['SelectedTypeNum'] : 0,
                        'nw' => $item['NW'] ?? null,
                        'gw' => $item['GW'] ?? null,
                        'dai' => is_numeric($item['Dai'] ?? null) ? (float)$item['Dai'] : null,
                        'rong' => is_numeric($item['Rong'] ?? null) ? (float)$item['Rong'] : null,
                        'cao' => is_numeric($item['Cao'] ?? null) ? (float)$item['Cao'] : null,
                        'color' => $item['COLOR'] ?? null,
                        'extended_content' => $item['ExtendedContent'] ?? null,
                        'lot_no' => $item['LotNo'] ?? null,
                        'quantity' => $item['QUANTITY'] ?? null,
                        'created_by' => $currentUser,
                        'last_modified_by' => $currentUser,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('thong-bao.containers', $thongBao->id)
                ->with('success', 'Đã tạo phiếu xuất hàng thành công. Hãy tiếp tục sắp xếp Container.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $thongBao = ThongBaoXuatHang::with([
            'chiTietHangHoas.containers'
        ])->findOrFail($id);

        $khachHangs = KhachHang::orderBy('name')->get();
        $hangHoas = HangHoa::orderBy('name')->get();

        return view('thong_bao_xuat_hang.quick_create', compact('khachHangs', 'hangHoas', 'thongBao'));
    }

    public function update(Request $request, $id)
    {
        $thongBao = ThongBaoXuatHang::with([
            'chiTietHangHoas',
            'containers'
        ])->findOrFail($id);

        $request->validate([
            'khach_hang_id' => 'required|exists:khach_hangs,id',
            'hang_hoa_id' => 'required|exists:hang_hoas,id',
            'loai_hang' => 'required|string|max:255',
            'so_luong' => 'required|integer|min:0',
            'ref_no' => 'required|string|max:255',
            'po_no' => 'required|string|max:255',
            'ngay_du_kien' => 'required|date',
            'ngay_etd' => 'required|date',
            'ghi_chu' => 'nullable|string',
        ]);

        $currentUser = Auth::user()->full_name ?? Auth::user()->name;

        // Perform smart item syncing
        $formItems = $request->get('ChiTietList', []);
        $formIds = collect($formItems)->pluck('ID')->filter()->map(fn($id) => (int)$id)->toArray();

        // 1. Check models marked for deletion
        $dbItems = $thongBao->chiTietHangHoas;
        $itemsToDelete = $dbItems->filter(fn($item) => !in_array($item->id, $formIds));

        foreach ($itemsToDelete as $item) {
            // Check if allocated to container
            $isAllocated = $thongBao->containers->contains('chi_tiet_hang_hoa_id', $item->id);
            if ($isAllocated) {
                return back()->withInput()->with('error', "Không thể xóa Model '{$item->model}' vì đã được xếp vào container. Vui lòng xóa khỏi container trước.");
            }
        }

        DB::beginTransaction();
        try {
            // Delete items safely
            foreach ($itemsToDelete as $item) {
                $item->delete();
            }

            // 2. Update existing or insert new items
            foreach ($formItems as $item) {
                if (empty($item['MODEL'])) {
                    continue;
                }

                $itemId = isset($item['ID']) ? (int)$item['ID'] : 0;
                $data = [
                    'model' => $item['MODEL'] ?? null,
                    'size' => $item['SIZE'] ?? null,
                    'so_luong_tham_khao' => is_numeric($item['SoLuongThamKhao'] ?? null) ? (int)$item['SoLuongThamKhao'] : 0,
                    'selected_type_num' => isset($item['SelectedTypeNum']) ? (int)$item['SelectedTypeNum'] : 0,
                    'nw' => $item['NW'] ?? null,
                    'gw' => $item['GW'] ?? null,
                    'dai' => is_numeric($item['Dai'] ?? null) ? (float)$item['Dai'] : null,
                    'rong' => is_numeric($item['Rong'] ?? null) ? (float)$item['Rong'] : null,
                    'cao' => is_numeric($item['Cao'] ?? null) ? (float)$item['Cao'] : null,
                    'color' => $item['COLOR'] ?? null,
                    'extended_content' => $item['ExtendedContent'] ?? null,
                    'lot_no' => $item['LotNo'] ?? null,
                    'quantity' => $item['QUANTITY'] ?? null,
                    'last_modified_by' => $currentUser,
                ];

                if ($itemId > 0) {
                    $existingItem = ChiTietHangHoa::findOrFail($itemId);
                    $existingItem->update($data);
                } else {
                    $data['thong_bao_xuat_hang_id'] = $thongBao->id;
                    $data['created_by'] = $currentUser;
                    ChiTietHangHoa::create($data);
                }
            }

            // 3. Update main notice fields
            $thongBao->update([
                'khach_hang_id' => $request->khach_hang_id,
                'hang_hoa_id' => $request->hang_hoa_id,
                'loai_hang' => $request->loai_hang,
                'so_luong' => $request->so_luong,
                'ref_no' => $request->ref_no,
                'po_no' => $request->po_no,
                'ngay_du_kien' => $request->ngay_du_kien,
                'ngay_etd' => $request->ngay_etd,
                'ghi_chu' => $request->ghi_chu,
                'last_modified_by' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('thong-bao.containers', $thongBao->id)
                ->with('success', 'Đã cập nhật phiếu xuất hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $thongBao = ThongBaoXuatHang::findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Delete cascading models explicitly (or let database cascade do it)
            // Due to constraints, let's delete them in code to be 100% safe
            $thongBao->containers()->delete();
            $thongBao->chiTietHangHoas()->delete();
            $thongBao->delete();

            DB::commit();
            return redirect()->route('thong-bao.index')
                ->with('success', 'Đã xóa thông báo xuất hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Không thể xóa thông báo xuất hàng: ' . $e->getMessage());
        }
    }

    public function manageContainers($id)
    {
        $thongBao = ThongBaoXuatHang::with([
            'khachHang',
            'hangHoa',
            'chiTietHangHoas',
            'containers.chiTietHangHoa'
        ])->findOrFail($id);

        $existingContainers = $thongBao->containers->map(function ($c) {
            return (object)[
                'id' => $c->id,
                'container_so' => $c->container_so,
                'kich_co' => $c->kich_co,
                'model_name' => $c->chiTietHangHoa?->model ?? '-',
                'so_luong' => $c->so_luong,
                'tu_den' => $c->tu . ' - ' . $c->den,
                'ghi_chu' => $c->ghi_chu,
            ];
        });

        return view('thong_bao_xuat_hang.manage_containers', compact('thongBao', 'existingContainers'));
    }

    public function storeContainer(Request $request, $id)
    {
        $request->validate([
            'container_so' => 'required|string|max:255',
            'kich_co' => 'required|string|max:255',
            'chi_tiet_hang_hoa_id' => 'required|exists:chi_tiet_hang_hoas,id',
            'so_luong' => 'required|string|max:255',
            'tu' => 'required|string|max:255',
            'den' => 'required|string|max:255',
            'ghi_chu' => 'nullable|string',
        ]);

        Container::create([
            'thong_bao_xuat_hang_id' => $id,
            'chi_tiet_hang_hoa_id' => $request->chi_tiet_hang_hoa_id,
            'container_so' => $request->container_so,
            'kich_co' => $request->kich_co,
            'so_luong' => $request->so_luong,
            'tu' => $request->tu,
            'den' => $request->den,
            'ghi_chu' => $request->ghi_chu,
        ]);

        return redirect()->route('thong-bao.containers', $id)
            ->with('success', 'Đã thêm Container sắp xếp thành công.');
    }

    public function editContainer($id)
    {
        $container = Container::with('thongBaoXuatHang.chiTietHangHoas')->findOrFail($id);
        
        return view('thong_bao_xuat_hang.edit_container', compact('container'));
    }

    public function updateContainer(Request $request, $id)
    {
        $container = Container::findOrFail($id);

        $request->validate([
            'container_so' => 'required|string|max:255',
            'kich_co' => 'required|string|max:255',
            'chi_tiet_hang_hoa_id' => 'required|exists:chi_tiet_hang_hoas,id',
            'so_luong' => 'required|string|max:255',
            'tu' => 'required|string|max:255',
            'den' => 'required|string|max:255',
            'ghi_chu' => 'nullable|string',
        ]);

        $container->update([
            'chi_tiet_hang_hoa_id' => $request->chi_tiet_hang_hoa_id,
            'container_so' => $request->container_so,
            'kich_co' => $request->kich_co,
            'so_luong' => $request->so_luong,
            'tu' => $request->tu,
            'den' => $request->den,
            'ghi_chu' => $request->ghi_chu,
        ]);

        return redirect()->route('thong-bao.containers', $container->thong_bao_xuat_hang_id)
            ->with('success', 'Đã cập nhật Container thành công.');
    }

    public function deleteContainer($id)
    {
        $container = Container::findOrFail($id);
        $thongBaoId = $container->thong_bao_xuat_hang_id;
        
        return view('thong_bao_xuat_hang.delete_container', compact('container', 'thongBaoId'));
    }

    public function destroyContainer($id)
    {
        $container = Container::findOrFail($id);
        $thongBaoId = $container->thong_bao_xuat_hang_id;
        $container->delete();

        return redirect()->route('thong-bao.containers', $thongBaoId)
            ->with('success', 'Đã xóa Container thành công.');
    }

    public function viewReport($id)
    {
        $thongBao = ThongBaoXuatHang::with([
            'khachHang',
            'hangHoa',
            'chiTietHangHoas',
            'containers.chiTietHangHoa',
            'creator'
        ])->findOrFail($id);

        $creatorName = $thongBao->creator?->full_name ?? $thongBao->creator?->name ?? 'Hệ thống';

        // Group containers by container number and size
        $containerGroups = $thongBao->containers->groupBy(function($c) {
            return $c->container_so . '|||' . $c->kich_co;
        })->map(function($group) {
            $first = $group->first();
            return (object)[
                'container_so' => $first->container_so,
                'kich_co' => $first->kich_co,
                'items' => $group->map(function($item) {
                    return (object)[
                        'so_luong' => $item->so_luong,
                        'model_name' => $item->chiTietHangHoa?->model,
                        'tu' => $item->tu,
                        'den' => $item->den,
                        'ghi_chu' => $item->ghi_chu,
                        'selected_type_num' => $item->chiTietHangHoa?->selected_type_num,
                    ];
                })
            ];
        })->values();

        return view('thong_bao_xuat_hang.report', compact('thongBao', 'containerGroups', 'creatorName'));
    }

    public function downloadPdf($id)
    {
        $thongBao = ThongBaoXuatHang::with([
            'khachHang',
            'hangHoa',
            'chiTietHangHoas',
            'containers.chiTietHangHoa',
            'creator'
        ])->findOrFail($id);

        $creatorName = $thongBao->creator?->full_name ?? $thongBao->creator?->name ?? 'Hệ thống';

        $containerGroups = $thongBao->containers->groupBy(function($c) {
            return $c->container_so . '|||' . $c->kich_co;
        })->map(function($group) {
            $first = $group->first();
            return (object)[
                'container_so' => $first->container_so,
                'kich_co' => $first->kich_co,
                'items' => $group->map(function($item) {
                    return (object)[
                        'so_luong' => $item->so_luong,
                        'model_name' => $item->chiTietHangHoa?->model,
                        'tu' => $item->tu,
                        'den' => $item->den,
                        'ghi_chu' => $item->ghi_chu,
                        'selected_type_num' => $item->chiTietHangHoa?->selected_type_num,
                    ];
                })
            ];
        })->values();

        $pdf = Pdf::loadView('thong_bao_xuat_hang.report', compact('thongBao', 'containerGroups', 'creatorName'));
        $pdf->setPaper('a4', 'landscape');
        $pdf->setOption('isRemoteEnabled', true);

        $safeRefNo = str_replace(['/', '\\'], '-', $thongBao->ref_no);
        return $pdf->download('TBXH_' . $safeRefNo . '_' . date('d_m_Y') . '.pdf');
    }
}
