@extends('layouts.app')

@section('title', 'Thêm Hàng hóa mới')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8">
        <div class="card card-custom border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-dark text-white p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-box-seam text-info fs-1 me-3"></i>
                    <div>
                        <h4 class="fw-bold mb-0">Thêm Hàng Hóa</h4>
                        <p class="text-muted-light mb-0" style="color: #94a3b8; font-size: 0.9rem;">Nhập thông tin hàng hóa mới vào danh mục sản phẩm</p>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('hang-hoas.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="code" class="form-label fw-semibold text-secondary">Mã Hàng Hóa</label>
                        <input type="text" 
                               name="code" 
                               id="code" 
                               class="form-control font-monospace @error('code') is-invalid @enderror" 
                               value="{{ old('code') }}" 
                               placeholder="VD: HH001" 
                               required 
                               style="letter-spacing: 0.5px; font-weight: 550;">
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Mã hàng hóa viết liền không dấu, là duy nhất trong hệ thống.</div>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label fw-semibold text-secondary">Tên Hàng Hóa</label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" 
                               placeholder="VD: Vải Polyester Xám" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-5 pt-3 border-top">
                        <a href="{{ route('hang-hoas.index') }}" class="btn btn-outline-secondary px-4 py-2">
                            <i class="bi bi-arrow-left me-2"></i>Quay lại
                        </a>
                        <button type="submit" class="btn btn-gradient-primary px-4 py-2 shadow-sm">
                            <i class="bi bi-save me-2"></i>Lưu hàng hóa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
