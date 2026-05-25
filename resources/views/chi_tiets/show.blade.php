@extends('layouts.app')

@section('title', 'Chi tiết Shipping Mark')

@section('content')
    <div class="card card-custom border-0 p-4 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="page-header mb-1">Chi tiết Shipping Mark</h2>
                <p class="text-muted mb-0">Xem chi tiết các thông số của nhãn vận chuyển</p>
            </div>
            <a href="{{ route('chi-tiets.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3">
                <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Trở về danh sách
            </a>
        </div>
    </div>

    <div class="card card-custom border-0 shadow-sm p-4">
        <div class="row g-4">
            <!-- Cột 1: Thông tin cơ bản -->
            <div class="col-lg-4 border-end-lg">
                <h5 class="mb-4 text-primary fw-semibold border-bottom pb-2"><i
                        class="bi bi-info-circle-fill me-2"></i>Thông tin cơ bản</h5>
                <dl class="row g-2 fs-6">
                    <dt class="col-sm-4 text-muted font-monospace">REFNO:</dt>
                    <dd class="col-sm-8 fw-bold">{{ $chiTiet->thongBaoXuatHang?->ref_no ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">PoNo:</dt>
                    <dd class="col-sm-8 fw-bold">{{ $chiTiet->thongBaoXuatHang?->po_no ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">MODEL:</dt>
                    <dd class="col-sm-8 fw-bold text-dark">{{ $chiTiet->model ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">SIZE:</dt>
                    <dd class="col-sm-8">{{ $chiTiet->size ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">NW / GW:</dt>
                    <dd class="col-sm-8">{{ $chiTiet->nw ?? '-' }} / {{ $chiTiet->gw ?? '-' }} kg</dd>

                    <dt class="col-sm-4 text-muted font-monospace">Kích thước:</dt>
                    <dd class="col-sm-8">
                        @if ($chiTiet->dai || $chiTiet->rong || $chiTiet->cao)
                            {{ (float) $chiTiet->dai }}m &times; {{ (float) $chiTiet->rong }}m &times;
                            {{ (float) $chiTiet->cao }}m
                        @else
                            -
                        @endif
                    </dd>

                    <dt class="col-sm-4 text-muted font-monospace">COLOR:</dt>
                    <dd class="col-sm-8">{{ $chiTiet->color ?? '-' }}</dd>
                </dl>
            </div>

            <!-- Cột 2: Đóng gói & In ấn -->
            <div class="col-lg-4 border-end-lg">
                <h5 class="mb-4 text-primary fw-semibold border-bottom pb-2"><i class="bi bi-printer-fill me-2"></i>In ấn &
                    Đóng gói</h5>
                <dl class="row g-2 fs-6">
                    <dt class="col-sm-4 text-muted font-monospace">Type:</dt>
                    <dd class="col-sm-8">{{ $chiTiet->selected_type_num?->label() ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">Hậu tố:</dt>
                    <dd class="col-sm-8">{{ $chiTiet->extended_content ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">Trạng thái:</dt>
                    <dd class="col-sm-8">
                        @if ($chiTiet->using_print)
                            <span class="bg-opacity-20 text-success border border-success border-opacity-50 px-2 py-1"><i
                                    class="bi bi-check-circle-fill me-1"></i>Đã in</span>
                        @else
                            <span class="bg-opacity-20 text-danger border border-danger border-opacity-50 px-2 py-1"><i
                                    class="bi bi-x-circle-fill me-1"></i>Chưa in</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4 text-muted font-monospace">Số bắt đầu:</dt>
                    <dd class="col-sm-8">{{ $chiTiet->containers->first()?->tu ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">Số lượng in:</dt>
                    <dd class="col-sm-8 fw-bold text-primary">{{ $chiTiet->containers->first()?->so_luong ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">LotNo:</dt>
                    <dd class="col-sm-8">{{ $chiTiet->lot_no ?? '-' }}</dd>

                    <dt class="col-sm-4 text-muted font-monospace">Loại nhảy số:</dt>
                    <dd class="col-sm-8">
                        @if ($chiTiet->selected_type_num)
                            <span class="badge bg-secondary">{{ $chiTiet->selected_type_num->label() }}</span>
                        @else
                            -
                        @endif
                    </dd>
                </dl>
            </div>

            <!-- Cột 3: Đối tác & Lịch sử -->
            <div class="col-lg-4">
                <h5 class="mb-4 text-primary fw-semibold border-bottom pb-2"><i class="bi bi-person-fill me-2"></i>Thông tin
                    khác</h5>
                <dl class="row g-2 fs-6">
                    <dt class="col-sm-5 text-muted font-monospace">Khách hàng:</dt>
                    <dd class="col-sm-7">{{ $chiTiet->thongBaoXuatHang?->khachHang?->name ?? '-' }}</dd>

                    <dt class="col-sm-5 text-muted font-monospace">Mã khách hàng:</dt>
                    <dd class="col-sm-7 font-monospace fw-bold">{{ $chiTiet->thongBaoXuatHang?->khachHang?->code ?? '-' }}
                    </dd>

                    <dt class="col-sm-5 text-muted font-monospace">Hàng hóa:</dt>
                    <dd class="col-sm-7">{{ $chiTiet->thongBaoXuatHang?->hangHoa?->name ?? '-' }}</dd>

                    <dt class="col-sm-5 text-muted font-monospace">Số lượng SP:</dt>
                    <dd class="col-sm-7">{{ $chiTiet->quantity ?? '-' }}</dd>

                    <dt class="col-sm-5 text-muted font-monospace">Người tạo:</dt>
                    <dd class="col-sm-7">{{ $chiTiet->created_by ?? '-' }}</dd>

                    <dt class="col-sm-5 text-muted font-monospace">Ngày tạo:</dt>
                    <dd class="col-sm-7 text-muted fs-7">
                        {{ $chiTiet->created_at ? $chiTiet->created_at->format('d/m/Y H:i:s') : '-' }}</dd>

                    <dt class="col-sm-5 text-muted font-monospace">Người cập nhật:</dt>
                    <dd class="col-sm-7">{{ $chiTiet->last_modified_by ?? '-' }}</dd>

                    <dt class="col-sm-5 text-muted font-monospace">Ngày cập nhật:</dt>
                    <dd class="col-sm-7 text-muted fs-7">
                        {{ $chiTiet->updated_at ? $chiTiet->updated_at->format('d/m/Y H:i:s') : '-' }}</dd>
                </dl>
            </div>
        </div>

        <div class="row mt-5 pt-3 border-top">
            <div class="col-12 text-center d-flex justify-content-center gap-2">
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'user')
                    @if (!$chiTiet->using_print)
                        <form action="{{ route('chi-tiets.confirm-print', $chiTiet->id) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-gradient-success px-4 py-2 rounded-3">
                                <i class="bi bi-printer me-1"></i> Xác nhận đã in
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('prints.select', ['id' => $chiTiet->id, 'source' => 'chitiet']) }}"
                        class="btn btn-outline-success px-4 py-2 rounded-3 print-btn">
                        <i class="bi bi-printer me-1"></i> In mẫu
                    </a>
                    <a href="{{ route('chi-tiets.edit', $chiTiet->id) }}" class="btn btn-warning px-4 py-2 rounded-3">
                        <i class="bi bi-pencil-square me-1"></i> Chỉnh sửa
                    </a>
                @endif
                <a href="{{ route('chi-tiets.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                    <i class="bi bi-list-ul me-1"></i> Trở về danh sách
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Print -->
    <div class="modal fade" id="printModal" tabindex="-1" aria-labelledby="printModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title font-bold text-xl" id="printModalLabel">Chọn Mẫu In (Shipping Mark)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="printModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                        <p class="mt-2 text-muted">Đang tải cấu hình in...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const printBtns = document.querySelectorAll('.print-btn');
            if (printBtns.length > 0) {
                const printModal = new bootstrap.Modal(document.getElementById('printModal'));
                const modalBody = document.getElementById('printModalBody');

                printBtns.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        let url = this.getAttribute('href');
                        url += (url.indexOf('?') > -1 ? '&' : '?') + 'modal=1';

                        modalBody.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                        <p class="mt-2 text-muted">Đang tải cấu hình in...</p>
                    </div>
                `;
                        printModal.show();

                        fetch(url)
                            .then(response => response.text())
                            .then(html => {
                                modalBody.innerHTML = html;
                            })
                            .catch(error => {
                                modalBody.innerHTML =
                                    '<div class="alert alert-danger">Đã có lỗi xảy ra. Không thể tải mẫu in.</div>';
                            });
                    });
                });
            }
        });
    </script>
@endsection
