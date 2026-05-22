@extends('layouts.app')

@section('title', 'Chỉnh sửa thông tin người dùng')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card card-custom border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-dark text-white p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-pencil-square text-info fs-1 me-3"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Chỉnh Sửa Thành Viên</h4>
                        <p class="text-muted-light mb-0" style="color: #94a3b8; font-size: 0.9rem;">Cập nhật thông tin và vai trò của {{ $user->full_name }}</p>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="name_display" class="form-label fw-semibold text-secondary">Tên đăng nhập (Username)</label>
                            <input type="text" id="name_display" class="form-control bg-light" value="{{ $user->name }}" readonly disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label fw-semibold text-secondary">Vai trò hệ thống</label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>USER (Thành viên thường)</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>ADMIN (Quản trị viên)</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại
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
