@extends('layouts.app')

@section('title', 'Danh sách SM')

@section('content')
    <div class="card card-custom border-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="page-header mb-1">Danh sách Shipping Mark (SM)</h2>
                <p class="text-muted mb-0">Quản lý và in các nhãn vận chuyển được tải lên hệ thống</p>
            </div>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <!-- Add container logic overrides manual creation -->
                <a href="{{ route('thong-bao.index') }}" class="btn btn-gradient-primary px-3 py-2 rounded-3">
                    <i class="bi bi-box-seam me-1"></i> Quản lý Thông báo xuất hàng
                </a>
            </div>
        </div>
    </div>

    <!-- Thống kê & Bộ lọc tìm kiếm -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8 col-md-7">
            <div class="card card-custom border-0 p-4 h-100 justify-content-center">
                <form action="{{ route('chi-tiets.index') }}" method="GET" class="row g-2">
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i
                                    class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0"
                                placeholder="Tìm kiếm theo REFNO, PoNo, Model, Khách hàng..."
                                value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-dark w-100 rounded-3">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4 col-md-5">
            <div class="card card-custom border-0 p-4 bg-info bg-opacity-10 h-100"
                style="border-left: 4px solid var(--bs-info) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-20 text-info p-3 rounded-circle">
                        <i class="bi bi-printer fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase text-muted fs-7 mb-1 font-monospace">Thông tin in ấn</h6>
                        <p class="mb-0 fs-5 text-dark fw-bold">Chưa in: <span
                                class="text-danger">{{ $unprintedCount }}</span> dòng</p>
                        <p class="mb-0 fs-6 text-muted">Tổng số Serial:
                            <strong>{{ number_format($totalNumSerial) }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng dữ liệu -->
    <div class="card card-custom border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark bg-opacity-50">
                    <tr>
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'user')
                            <th class="ps-4 text-nowrap" style="width: 350px;">Hành động</th>
                        @endif
                        <th class="text-nowrap">Trạng thái</th>
                        <th class="text-nowrap">REFNO</th>
                        <th class="text-nowrap">PoNo</th>
                        <th class="text-nowrap">MODEL</th>
                        <th class="text-nowrap">SIZE</th>
                        <th class="text-nowrap">GW (kg)</th>
                        <th class="text-nowrap">COLOR</th>
                        <th class="text-nowrap">Loại đóng gói</th>
                        <th class="text-nowrap">Hậu tố</th>
                        <th class="text-nowrap">Số bắt đầu</th>
                        <th class="text-nowrap">Số lượng in</th>
                        <th class="text-nowrap">LotNo</th>
                        <th class="text-nowrap">Khách hàng</th>
                        <th class="text-nowrap">Số lượng</th>
                        <th class="text-nowrap">Hàng hóa</th>
                        <th class="text-nowrap">Mã khách hàng</th>
                        <th class="text-nowrap">Người tạo</th>
                        <th class="text-nowrap">Ngày tạo</th>
                        <th class="text-nowrap">Người cập nhật cuối</th>
                        <th class="text-nowrap pe-4">Ngày cập nhật cuối</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($chiTiets as $item)
                        <tr class="{{ $item->usingPrint ? 'table-success bg-opacity-10' : 'table-danger bg-opacity-10' }}">
                            @if (auth()->user()->role === 'admin' || auth()->user()->role === 'user')
                                <td class="ps-4 text-nowrap">
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('chi-tiets.show', $item->ID) }}"
                                            class="btn btn-outline-info btn-sm" title="Xem chi tiết">
                                            <i class="bi bi-eye"></i> Xem
                                        </a>
                                        <a href="{{ route('chi-tiets.edit', $item->ID) }}"
                                            class="btn btn-outline-warning btn-sm" title="Chỉnh sửa">
                                            <i class="bi bi-pencil-square"></i> Sửa
                                        </a>
                                        <a href="{{ route('prints.select', $item->ID) }}"
                                            class="btn btn-outline-success btn-sm print-btn" title="In mẫu">
                                            <i class="bi bi-printer"></i> In SM
                                        </a>
                                        @if (!$item->usingPrint)
                                            <form action="{{ route('chi-tiets.confirm-print', $item->ID) }}" method="POST"
                                                class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-primary btn-sm"
                                                    title="Đánh dấu đã in">
                                                    <i class="bi bi-check2-circle"></i> Xác nhận đã in
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            @endif
                            <td class="text-nowrap">
                                @if ($item->usingPrint)
                                    <span class="badge text-success border border-success border-opacity-50 px-2 py-1.5"><i
                                            class="bi bi-check-circle-fill me-1"></i>Đã in</span>
                                @else
                                    <span class="badge text-warning border border-warning border-opacity-50 px-2 py-1.5"><i
                                            class="bi bi-x-circle-fill me-1"></i>Chưa in</span>
                                @endif
                            </td>
                            <td class="text-nowrap">{{ $item->REFNO }}</td>
                            <td class="text-nowrap">{{ $item->PoNo }}</td>
                            <td class="text-nowrap fw-bold">{{ $item->MODEL }}</td>
                            <td class="text-nowrap">{{ $item->SIZE }}</td>
                            <td class="text-nowrap">{{ $item->GW }}</td>
                            <td class="text-nowrap">{{ $item->COLOR }}</td>
                            <td class="text-nowrap">
                                <span class="badge bg-secondary">{{ $item->TypeText }}</span>
                            </td>
                            <td class="text-nowrap">{{ $item->TypeSuffix }}</td>
                            <td class="text-nowrap">{{ $item->StartSerial }}</td>
                            <td class="text-nowrap fw-bold text-primary">{{ $item->NumSerial }}</td>
                            <td class="text-nowrap">{{ $item->LotNo }}</td>
                            <td class="text-nowrap">{{ $item->Customer }}</td>
                            <td class="text-nowrap">{{ $item->QUANTITY }}</td>
                            <td class="text-nowrap">{{ $item->COMMODITY }}</td>
                            <td class="text-nowrap font-monospace">{{ $item->CustomerCode }}</td>
                            <td class="text-nowrap text-muted text-center">-</td>
                            <td class="text-nowrap text-muted fs-7 text-center">-</td>
                            <td class="text-nowrap text-muted text-center">-</td>
                            <td class="text-nowrap text-muted fs-7 pe-4 text-center">-</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="21" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                                Không có dữ liệu Shipping Mark nào được tìm thấy.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $chiTiets->links('pagination::bootstrap-5') }}
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
            const printModal = new bootstrap.Modal(document.getElementById('printModal'));
            const modalBody = document.getElementById('printModalBody');

            printBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Lấy URL và thêm tham số modal=1
                    let url = this.getAttribute('href');
                    url += (url.indexOf('?') > -1 ? '&' : '?') + 'modal=1';

                    // Show loading state
                    modalBody.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-2 text-muted">Đang tải cấu hình in...</p>
                </div>
            `;
                    printModal.show();

                    // Fetch nội dung HTML
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
        });
    </script>
@endsection
