@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card card-custom border-0 shadow-sm overflow-hidden mb-4">
            <div class="card-header bg-dark text-white p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-gear text-info fs-1 me-3"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Quản Lý Tài Khoản</h4>
                        <p class="text-muted-light mb-0" style="color: #94a3b8; font-size: 0.9rem;">Cập nhật thông tin cá nhân và thay đổi mật khẩu của bạn</p>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    
                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-4">
                        <i class="bi bi-person-vcard text-primary me-2"></i>Thông tin tài khoản
                    </h5>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="username_display" class="form-label fw-semibold text-secondary">Tên đăng nhập (Username)</label>
                            <input type="text" id="username_display" class="form-control bg-light" value="{{ $user->name }}" readonly disabled>
                            <div class="form-text text-muted">Tên đăng nhập không thể thay đổi.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="role_display" class="form-label fw-semibold text-secondary">Vai trò</label>
                            <input type="text" id="role_display" class="form-control bg-light text-uppercase fw-bold text-success" value="{{ $user->role }}" readonly disabled>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="full_name" class="form-label fw-semibold text-secondary">Họ và Tên</label>
                        <input type="text" 
                               name="full_name" 
                               id="full_name" 
                               class="form-control @error('full_name') is-invalid @enderror" 
                               value="{{ old('full_name', $user->full_name) }}" 
                               required>
                        @error('full_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold text-secondary">Địa chỉ Email</label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <h5 class="fw-bold text-dark border-bottom pb-2 mb-4 mt-5">
                        <i class="bi bi-shield-lock text-primary me-2"></i>Thay đổi mật khẩu
                    </h5>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">Chỉ điền vào các ô bên dưới nếu bạn muốn thay đổi mật khẩu hiện tại.</p>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="password" class="form-label fw-semibold text-secondary">Mật khẩu mới</label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Tối thiểu 6 ký tự">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold text-secondary">Xác nhận mật khẩu mới</label>
                            <input type="password" 
                                   name="password_confirmation" 
                                   id="password_confirmation" 
                                   class="form-control" 
                                   placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại trang chủ
                        </a>
                        <button type="submit" class="btn btn-gradient-primary px-4 py-2 shadow-sm">
                            <i class="bi bi-save me-2"></i>Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
