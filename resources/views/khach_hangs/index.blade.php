@extends('layouts.app')

@section('title', 'Danh sách Khách hàng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-header mb-1">Danh Sách Khách Hàng</h2>
        <p class="text-muted mb-0">Quản lý danh mục đối tác khách hàng xuất khẩu</p>
    </div>
    <a href="{{ route('khach-hangs.create') }}" class="btn btn-gradient-primary rounded-3 shadow-sm px-3 py-2">
        <i class="bi bi-plus-lg me-2"></i>Thêm khách hàng
    </a>
</div>

<div class="card card-custom border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                <tr>
                    <th class="ps-4" style="width: 80px;">STT</th>
                    <th style="width: 250px;">Mã Khách Hàng</th>
                    <th>Tên Khách Hàng</th>
                    <th class="text-end pe-4" style="width: 150px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($khachHangs as $index => $khachHang)
                    <tr>
                        <td class="ps-4 fw-semibold text-muted">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary fw-bold font-monospace px-2.5 py-1.5" style="font-size: 0.9rem;">
                                {{ $khachHang->code }}
                            </span>
                        </td>
                        <td class="fw-medium text-dark">{{ $khachHang->name }}</td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-xs">
                                <a href="{{ route('khach-hangs.edit', $khachHang->id) }}" class="btn btn-outline-secondary btn-sm" title="Sửa">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Xóa" onclick="confirmDelete('{{ $khachHang->id }}', '{{ $khachHang->name }}')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </div>
                            
                            <form id="delete-form-{{ $khachHang->id }}" action="{{ route('khach-hangs.destroy', $khachHang->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2 text-secondary"></i>
                            Chưa có khách hàng nào được tạo.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="deleteModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Xác nhận xóa khách hàng</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-trash3 text-danger" style="font-size: 3.5rem;"></i>
                <p class="mt-3 mb-0 fs-5">Bạn có chắc chắn muốn xóa khách hàng <strong id="delete-item-name" class="text-dark"></strong>?</p>
                <p class="text-danger mt-1 mb-0" style="font-size: 0.85rem;"><i class="bi bi-info-circle me-1"></i>Hệ thống sẽ không cho phép xóa nếu có dữ liệu xuất hàng liên quan.</p>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Đồng ý xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let activeId = null;

    function confirmDelete(id, name) {
        activeId = id;
        document.getElementById('delete-item-name').innerText = name;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    document.getElementById('confirm-delete-btn').addEventListener('click', function() {
        if (activeId) {
            document.getElementById('delete-form-' + activeId).submit();
        }
    });
</script>
@endsection
