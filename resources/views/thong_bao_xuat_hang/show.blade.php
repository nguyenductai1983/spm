@extends('layouts.app')

@section('title', 'Chi tiết Thông báo xuất hàng - ' . $thongBao->ref_no)

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h2 class="page-header mb-1">Chi tiết Thông báo xuất hàng</h2>
        <p class="text-muted mb-0">REF No: <strong class="text-primary">{{ $thongBao->ref_no }}</strong> | PO No: <strong>{{ $thongBao->po_no }}</strong></p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <div class="btn-group shadow-sm">
            <a href="{{ route('thong-bao.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Danh sách
            </a>
            <a href="{{ route('thong-bao.edit', $thongBao->id) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-1"></i> Sửa phiếu
            </a>
            <a href="{{ route('thong-bao.containers', $thongBao->id) }}" class="btn btn-outline-warning">
                <i class="bi bi-box-seam me-1"></i> Xếp Container
            </a>
            <a href="{{ route('thong-bao.report', $thongBao->id) }}" class="btn btn-primary btn-gradient-primary">
                <i class="bi bi-printer me-1"></i> In báo cáo
            </a>
            <a href="{{ route('thong-bao.pdf', $thongBao->id) }}" class="btn btn-success btn-gradient-success">
                <i class="bi bi-file-pdf me-1"></i> Tải PDF
            </a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- General Information -->
    <div class="col-lg-4">
        <div class="card card-custom border-0 p-4 h-100">
            <h5 class="fw-bold mb-4 border-bottom pb-2"><i class="bi bi-info-circle text-primary me-2"></i> Thông tin chung</h5>
            
            <div class="mb-3">
                <span class="text-muted small d-block">Khách hàng</span>
                <strong class="fs-6">{{ $thongBao->khachHang?->name ?? 'Không rõ' }}</strong>
            </div>
            
            <div class="mb-3">
                <span class="text-muted small d-block">Hàng hóa</span>
                <strong class="fs-6">{{ $thongBao->hangHoa?->name ?? 'Không rõ' }}</strong>
            </div>
            
            <div class="mb-3">
                <span class="text-muted small d-block">Loại hàng</span>
                <span class="badge bg-info-subtle text-info fs-6 px-3 py-1.5 rounded-pill">{{ $thongBao->loai_hang }}</span>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Tổng số lượng (Kế hoạch)</span>
                <strong class="fs-5 text-primary">{{ number_format($thongBao->so_luong) }}</strong>
            </div>

            <hr class="my-3 text-slate-300">

            <div class="mb-3">
                <span class="text-muted small d-block">Ngày dự kiến xuất</span>
                <span class="fw-semibold"><i class="bi bi-calendar-event me-2 text-secondary"></i>{{ \Carbon\Carbon::parse($thongBao->ngay_du_kien)->format('d/m/Y') }}</span>
            </div>
            
            <div class="mb-3">
                <span class="text-muted small d-block">Ngày ETD</span>
                <span class="fw-semibold"><i class="bi bi-calendar-check me-2 text-secondary"></i>{{ \Carbon\Carbon::parse($thongBao->ngay_etd)->format('d/m/Y') }}</span>
            </div>

            <div class="mb-3">
                <span class="text-muted small d-block">Ghi chú phiếu</span>
                <p class="text-muted bg-light p-2 rounded mb-0 text-break" style="font-size: 0.9rem;">
                    {{ $thongBao->ghi_chu ?? '(Không có ghi chú)' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Items and Container Mappings -->
    <div class="col-lg-8">
        <!-- Goods List -->
        <div class="card card-custom border-0 p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-box me-2 text-warning"></i> Chi tiết mặt hàng xuất</h5>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Model</th>
                            <th>Size (Quy cách)</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Loại</th>
                            <th class="text-center">NW / GW (kg)</th>
                            <th class="text-center">Lô / Hạn dùng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($thongBao->chiTietHangHoas as $item)
                            <tr>
                                <td><strong>{{ $item->model }}</strong></td>
                                <td>{{ $item->size }}</td>
                                <td class="text-center fw-bold text-primary">{{ $item->so_luong_tham_khao }}</td>
                                <td class="text-center"><span class="badge bg-secondary">{{ $item->selected_type_num->label() }}</span></td>
                                <td class="text-center font-monospace">{{ $item->nw ?? '-' }} / {{ $item->gw ?? '-' }}</td>
                                <td class="text-center small">{{ $item->lot_no ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Chưa có chi tiết hàng hóa nào được tạo.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Container Allocations -->
        <div class="card card-custom border-0 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-truck me-2 text-success"></i> Sắp xếp vị trí Container</h5>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Số Container</th>
                            <th>Kích cỡ</th>
                            <th>Model xếp</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-center">Serial (Từ - Đến)</th>
                            <th>Ghi chú xếp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($thongBao->containers as $c)
                            <tr>
                                <td><strong class="text-primary">{{ $c->container_so }}</strong></td>
                                <td><span class="badge bg-dark">{{ $c->kich_co }}</span></td>
                                <td>{{ $c->chiTietHangHoa?->model ?? '-' }}</td>
                                <td class="text-center fw-bold">{{ $c->so_luong }}</td>
                                <td class="text-center font-monospace">{{ $c->tu }} - {{ $c->den }}</td>
                                <td><small class="text-muted">{{ $c->ghi_chu ?? '-' }}</small></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Chưa có thông tin xếp container.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
