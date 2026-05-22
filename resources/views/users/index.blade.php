@extends('layouts.app')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="page-header mb-1">Quản Lý Người Dùng</h2>
        <p class="text-muted mb-0">Quản trị viên có thể xem, tạo, sửa và cấp quyền thành viên</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-gradient-primary rounded-3 shadow-sm px-3 py-2">
        <i class="bi bi-person-plus-fill me-2"></i>Thêm người dùng mới
    </a>
</div>

<div class="card card-custom border-0 shadow-sm overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                <tr>
                    <th class="ps-4">Họ và Tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th>Ngày đăng ký</th>
                    <th class="text-end pe-4">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->full_name ?? $user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $user->full_name }}</h6>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-info text-dark" style="font-size: 0.7rem;">Bạn</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><span class="font-monospace text-muted">{{ $user->name }}</span></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger-subtle px-2 py-1.5"><i class="bi bi-shield-lock-fill me-1"></i>ADMIN</span>
                            @else
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2 py-1.5"><i class="bi bi-person-fill me-1"></i>USER</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $user->created_at ? $user->created_at->format('H:i d/m/Y') : 'N/A' }}</small>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-secondary btn-sm" title="Chỉnh sửa thông tin">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <a href="{{ route('users.password.edit', $user->id) }}" class="btn btn-outline-warning btn-sm" title="Đổi mật khẩu">
                                    <i class="bi bi-key-fill"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <button type="button" class="btn btn-outline-danger btn-sm" title="Xóa tài khoản" onclick="confirmDelete('{{ $user->id }}', '{{ $user->full_name }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                    
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            Chưa có người dùng nào được cấu hình.
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
                <h5 class="modal-title fw-bold" id="deleteModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>Xác nhận xóa tài khoản</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-person-x text-danger" style="font-size: 3.5rem;"></i>
                <p class="mt-3 mb-0 fs-5">Bạn có chắc chắn muốn xóa tài khoản của thành viên <strong id="delete-username" class="text-dark"></strong>?</p>
                <p class="text-danger mt-1 mb-0" style="font-size: 0.85rem;"><i class="bi bi-info-circle me-1"></i>Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-btn">Xác nhận xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let activeUserId = null;

    function confirmDelete(id, fullName) {
        activeUserId = id;
        document.getElementById('delete-username').innerText = fullName;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    document.getElementById('confirm-delete-btn').addEventListener('click', function() {
        if (activeUserId) {
            document.getElementById('delete-form-' + activeUserId).submit();
        }
    });
</script>
@endsection
