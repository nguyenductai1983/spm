@extends('layouts.app')

@section('title', 'Thông báo xuất hàng')

@section('content')
<div class="card card-custom border-0 p-4 mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="page-header mb-1">Thông báo xuất hàng (TBXH)</h2>
            <p class="text-muted mb-0">Quản lý quy trình xuất hàng và phân bổ container</p>
        </div>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user')
            <a href="{{ route('thong-bao.quick-create') }}" class="btn btn-gradient-primary px-4 py-2.5 rounded-3">
                <i class="bi bi-plus-circle me-1"></i> Tạo Thông báo mới
            </a>
        @endif
    </div>
</div>

<div class="card card-custom border-0 shadow-sm p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark bg-opacity-50">
                <tr>
                    <th class="ps-4">Khách hàng</th>
                    <th>Số PO</th>
                    <th>REFNO (Đơn hàng)</th>
                    <th>Ngày dự kiến</th>
                    <th class="pe-4 text-end" style="width: 480px;">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @forelse($thongBaoList as $item)
                    <tr>
                        <td class="ps-4 fw-medium text-dark">{{ $item->khachHang?->name ?? '-' }}</td>
                        <td class="fw-bold text-primary">{{ $item->po_no }}</td>
                        <td>{{ $item->ref_no }}</td>
                        <td class="text-danger fw-semibold">
                            {{ $item->ngay_du_kien ? $item->ngay_du_kien->format('d/m/Y') : '-' }}
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-1.5 flex-wrap">
                                <a href="{{ route('thong-bao.report', $item->id) }}" class="btn btn-info btn-sm text-white px-2.5" target="_blank">
                                    <i class="bi bi-printer-fill me-1"></i> In TBXH
                                </a>
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'user')
                                    <a href="{{ route('thong-bao.edit', $item->id) }}" class="btn btn-outline-primary btn-sm px-2.5">
                                        <i class="bi bi-pencil-square me-1"></i> Sửa
                                    </a>
                                    <a href="{{ route('thong-bao.containers', $item->id) }}" class="btn btn-outline-success btn-sm px-2.5">
                                        <i class="bi bi-box-seam me-1"></i> Xếp Cont
                                    </a>
                                    <a href="{{ route('thong-bao.show', $item->id) }}" class="btn btn-outline-secondary btn-sm px-2.5">
                                        <i class="bi bi-eye me-1"></i> Chi tiết
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('thong-bao.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa Thông báo này? Tất cả các mặt hàng chi tiết và Container phân bổ sẽ bị xóa vĩnh viễn.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2.5">
                                                <i class="bi bi-trash me-1"></i> Xóa
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                            Chưa có thông báo xuất hàng nào được tạo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
