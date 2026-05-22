@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-12 col-md-6 col-lg-5">
        <div class="card card-custom border-0 overflow-hidden shadow-lg">
            <div class="p-4 bg-dark text-white text-center position-relative" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;">
                <div class="mb-2">
                    <i class="bi bi-shield-lock-fill text-info" style="font-size: 3rem;"></i>
                </div>
                <h3 class="fw-bold mb-1">Đăng Nhập Hệ Thống</h3>
                <p class="text-muted-light mb-0" style="color: #94a3b8; font-size: 0.9rem;">Sử dụng tài khoản của bạn để truy cập</p>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('login') }}" method="POST" class="needs-validation">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="username" class="form-label fw-semibold text-secondary">Tên đăng nhập hoặc Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-fill"></i></span>
                            <input type="text" 
                                   name="username" 
                                   id="username" 
                                   class="form-control bg-light border-start-0 ps-0 @error('username') is-invalid @enderror" 
                                   placeholder="admin hoặc admin@gmail.com" 
                                   value="{{ old('username') }}" 
                                   required 
                                   autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold text-secondary">Mật khẩu</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key-fill"></i></span>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control bg-light border-start-0 ps-0 @error('password') is-invalid @enderror" 
                                   placeholder="••••••••" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4 align-items-center">
                        <div class="col-6">
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="form-check-label text-muted" style="font-size: 0.9rem;">Ghi nhớ đăng nhập</label>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <span class="text-muted" style="font-size: 0.9rem;">admin123 (pass mặc định)</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gradient-primary w-100 py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-arrow-in-right me-2 fs-5"></i> Đăng nhập
                    </button>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0" style="font-size: 0.9rem;">
                            Chưa có tài khoản? <a href="{{ route('register') }}" class="text-info fw-bold text-decoration-none">Đăng ký ngay</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
