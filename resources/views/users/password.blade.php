@extends('layouts.app')

@section('title', 'Đổi mật khẩu người dùng')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card card-custom border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-dark text-white p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-key-fill text-info fs-1 me-3"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Đặt Lại Mật Khẩu</h4>
                        <p class="text-muted-light mb-0" style="color: #94a3b8; font-size: 0.9rem;">Thay đổi mật khẩu đăng nhập cho {{ $user->full_name }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('users.password.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name_display" class="form-label fw-semibold text-secondary">Tên đăng nhập (Username)</label>
                        <input type="text" id="name_display" class="form-control bg-light" value="{{ $user->name }}" readonly disabled>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="password" class="form-label fw-semibold text-secondary">Mật khẩu mới</label>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="Tối thiểu 6 ký tự" 
                                   required 
                                   autofocus>
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
                                   placeholder="Nhập lại mật khẩu mới" 
                                   required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại
                        </a>
                        <button type="submit" class="btn btn-gradient-primary px-4 py-2 shadow-sm">
                            <i class="bi bi-save me-2"></i>Cập nhật mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
