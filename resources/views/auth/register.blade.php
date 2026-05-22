@extends('layouts.app')

@section('title', 'Đăng ký')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-custom border-0 overflow-hidden shadow-lg">
            <div class="p-4 bg-dark text-white text-center position-relative" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;">
                <div class="mb-2">
                    <i class="bi bi-person-plus-fill text-info" style="font-size: 3rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">Đăng Ký Tài Khoản</h3>
                <p class="text-muted-light mb-0" style="color: #94a3b8; font-size: 0.9rem;">Tạo tài khoản mới để bắt đầu sử dụng</p>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="full_name" class="form-label fw-semibold text-secondary">Họ và Tên</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-card-text"></i></span>
                            <input type="text" 
                                   name="full_name" 
                                   id="full_name" 
                                   class="form-control bg-light border-start-0 ps-0 @error('full_name') is-invalid @enderror" 
                                   placeholder="Nguyễn Văn A" 
                                   value="{{ old('full_name') }}" 
                                   required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-secondary">Tên đăng nhập (Username)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-badge"></i></span>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   class="form-control bg-light border-start-0 ps-0 @error('name') is-invalid @enderror" 
                                   placeholder="nguyenvana" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-secondary">Địa chỉ Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                   placeholder="nguyenvana@example.com" 
                                   value="{{ old('email') }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-semibold text-secondary">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="form-control bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                       placeholder="Tối thiểu 6 ký tự" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold text-secondary">Nhập lại mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="form-control bg-light border-start-0 ps-0" 
                                       placeholder="••••••••" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gradient-success w-100 py-2.5 rounded-3 shadow-sm mt-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-person-plus-fill me-2 fs-5"></i> Đăng ký tài khoản
                    </button>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                            Đã có tài khoản? <a href="{{ route('login') }}" class="text-info fw-bold text-decoration-none">Đăng nhập</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
