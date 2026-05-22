@extends('layouts.app')

@section('title', 'Sắp xếp Container - ' . $thongBao->ref_no)

@section('styles')
<style>
    .wizard-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        position: relative;
    }
    .wizard-steps::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #e2e8f0;
        z-index: 1;
        transform: translateY(-50%);
    }
    .wizard-step {
        background-color: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #64748b;
        position: relative;
        z-index: 2;
    }
    .wizard-step.active {
        border-color: #3b82f6;
        background-color: #3b82f6;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }
    .wizard-step.completed {
        border-color: #10b981;
        background-color: #10b981;
        color: #ffffff;
    }
    .wizard-label {
        position: absolute;
        top: 45px;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
        color: #64748b;
    }
    .wizard-step.active .wizard-label {
        color: #3b82f6;
        font-weight: 600;
    }
    .wizard-step.completed .wizard-label {
        color: #10b981;
    }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="page-header mb-3">Quy trình Xếp hàng vào Container</h2>
        <p class="text-muted">Phiếu xuất hàng REF: <strong>{{ $thongBao->ref_no }}</strong> | PO: <strong>{{ $thongBao->po_no }}</strong></p>
    </div>
</div>

<!-- Wizard Indicator -->
<div class="row justify-content-center mb-5">
    <div class="col-md-8 col-lg-6">
        <div class="wizard-steps">
            <div class="wizard-step completed">
                1
                <span class="wizard-label">Thông tin & Hàng hóa</span>
            </div>
            <div class="wizard-step active">
                2
                <span class="wizard-label">Sắp xếp Container</span>
            </div>
            <div class="wizard-step">
                3
                <span class="wizard-label">In nhãn & Báo cáo</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Container Form and Allocations List -->
    <div class="col-lg-8">
        <!-- Allocations List -->
        <div class="card card-custom border-0 p-4 mb-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-box-seam text-primary me-2"></i> Danh sách Container đã xếp</h5>
            
            @if($existingContainers->isEmpty())
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-3 text-slate-300"></i>
                    Chưa có container nào được xếp. Sử dụng biểu mẫu bên phải để thêm container mới.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Số Container</th>
                                <th>Kích cỡ</th>
                                <th>Model hàng hóa</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-center">Số thứ tự (Từ - Đến)</th>
                                <th>Ghi chú</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($existingContainers as $container)
                                <tr>
                                    <td><strong class="text-primary">{{ $container->container_so }}</strong></td>
                                    <td><span class="badge bg-secondary">{{ $container->kich_co }}</span></td>
                                    <td>{{ $container->model_name }}</td>
                                    <td class="text-center fw-semibold">{{ $container->so_luong }}</td>
                                    <td class="text-center"><span class="badge bg-light text-dark font-monospace">{{ $container->tu_den }}</span></td>
                                    <td><small class="text-muted">{{ $container->ghi_chu ?? '-' }}</small></td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('containers.edit', $container->id) }}" class="btn btn-outline-primary" title="Chỉnh sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('containers.delete-confirm', $container->id) }}" class="btn btn-outline-danger" title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Navigation Actions -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('thong-bao.edit', $thongBao->id) }}" class="btn btn-outline-secondary px-4">
                <i class="bi bi-arrow-left me-2"></i> Quay lại Bước 1
            </a>
            
            <a href="{{ route('thong-bao.report', $thongBao->id) }}" class="btn btn-success px-4 btn-gradient-success">
                Hoàn thành & Xem Báo Cáo <i class="bi bi-file-earmark-bar-graph ms-2"></i>
            </a>
        </div>
    </div>

    <!-- Right Column: Quick Add and Reference Items -->
    <div class="col-lg-4">
        <!-- Add Container Form -->
        <div class="card card-custom border-0 p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-plus-circle text-success me-2"></i> Thêm Xếp Container</h5>
            
            <form action="{{ route('thong-bao.containers.store', $thongBao->id) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="container_so" class="form-label fw-semibold">Số Container <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="container_so" name="container_so" required placeholder="Ví dụ: TGBU2345678" value="{{ old('container_so') }}">
                    @error('container_so') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="kich_co" class="form-label fw-semibold">Kích cỡ <span class="text-danger">*</span></label>
                    <select class="form-select" id="kich_co" name="kich_co" required>
                        <option value="40'HC" {{ old('kich_co') == "40'HC" ? 'selected' : '' }}>40'HC</option>
                        <option value="20'GP" {{ old('kich_co') == "20'GP" ? 'selected' : '' }}>20'GP</option>
                        <option value="45'HC" {{ old('kich_co') == "45'HC" ? 'selected' : '' }}>45'HC</option>
                        <option value="LCL" {{ old('kich_co') == 'LCL' ? 'selected' : '' }}>LCL (Hàng lẻ)</option>
                    </select>
                    @error('kich_co') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="chi_tiet_hang_hoa_id" class="form-label fw-semibold">Model hàng hóa <span class="text-danger">*</span></label>
                    <select class="form-select" id="chi_tiet_hang_hoa_id" name="chi_tiet_hang_hoa_id" required>
                        <option value="">-- Chọn Model --</option>
                        @foreach($thongBao->chiTietHangHoas as $item)
                            <option value="{{ $item->id }}" {{ old('chi_tiet_hang_hoa_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->model }} (TK: {{ $item->so_luong_tham_khao }} {{ $item->selected_type_num->label() }})
                            </option>
                        @endforeach
                    </select>
                    @error('chi_tiet_hang_hoa_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="so_luong" class="form-label fw-semibold">Số lượng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="so_luong" name="so_luong" required placeholder="Ví dụ: 150" value="{{ old('so_luong') }}">
                    @error('so_luong') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="tu" class="form-label fw-semibold">Từ số <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tu" name="tu" required placeholder="1" value="{{ old('tu') }}">
                        @error('tu') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="den" class="form-label fw-semibold">Đến số <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="den" name="den" required placeholder="150" value="{{ old('den') }}">
                        @error('den') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="ghi_chu" class="form-label fw-semibold">Ghi chú</label>
                    <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="2" placeholder="Ghi chú thêm...">{{ old('ghi_chu') }}</textarea>
                    @error('ghi_chu') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <button type="submit" class="btn btn-gradient-primary w-100 py-2"><i class="bi bi-plus-circle me-1"></i> Lưu & Thêm</button>
            </form>
        </div>
        
        <!-- Reference Items List in Thong Bao -->
        <div class="card card-custom border-0 p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-info-circle text-info me-2"></i> Danh sách mặt hàng tham chiếu</h6>
            <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                @foreach($thongBao->chiTietHangHoas as $item)
                    <div class="list-group-item px-0 py-2 bg-transparent border-0 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="d-block">{{ $item->model }}</strong>
                                <span class="text-muted small">Quy cách: {{ $item->size }}</span>
                            </div>
                            <span class="badge bg-primary-subtle text-primary rounded-pill">
                                {{ $item->so_luong_tham_khao }} {{ $item->selected_type_num->label() }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
