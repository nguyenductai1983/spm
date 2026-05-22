@extends('layouts.app')

@section('title', 'Import Dữ liệu từ Excel')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-7">
        <!-- Card -->
        <div class="card card-custom border-0 shadow-sm overflow-hidden mb-4">
            <div class="card-header bg-dark text-white p-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-excel-fill text-success fs-1 me-3"></i>
                        <div>
                            <h4 class="fw-bold mb-0">Nhập Dữ Liệu Excel</h4>
                            <p class="text-muted-light mb-0" style="color: #94a3b8; font-size: 0.9rem;">Nhập danh sách Shipping Mark từ tệp bảng tính</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <!-- Instruction Box -->
                <div class="alert alert-info border-0 rounded-3 mb-4 p-3 bg-info bg-opacity-10 text-info-emphasis">
                    <h6 class="fw-bold mb-2"><i class="bi bi-info-circle-fill me-2"></i>Hướng dẫn nhanh:</h6>
                    <ul class="mb-0 ps-3" style="font-size: 0.9rem;">
                        <li>Định dạng file được hỗ trợ là <strong>.xlsx</strong> hoặc <strong>.xls</strong>.</li>
                        <li>Dữ liệu cần bắt đầu từ dòng thứ 2 (bỏ qua tiêu đề).</li>
                        <li>Đảm bảo các cột đúng theo thứ tự mẫu đã định nghĩa.</li>
                    </ul>
                    <div class="mt-3">
                        <a href="{{ route('chi-tiet.export-template') }}" class="btn btn-sm btn-success shadow-sm rounded-2">
                            <i class="bi bi-download me-1"></i> Tải file Excel mẫu tại đây
                        </a>
                    </div>
                </div>

                <form action="{{ route('chi-tiet.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="file" class="form-label fw-semibold text-secondary">Chọn File Excel của bạn</label>
                        <div class="border border-dashed rounded-3 p-4 text-center bg-light position-relative hover-shadow" style="border-style: dashed !important; border-color: #cbd5e1 !important;">
                            <i class="bi bi-cloud-arrow-up text-muted" style="font-size: 3rem;"></i>
                            <div class="mt-2">
                                <label for="file" class="btn btn-sm btn-outline-primary px-3 rounded-2">Tìm file trên máy tính</label>
                                <input type="file" name="file" id="file" class="d-none" accept=".xlsx, .xls" required onchange="showFileName(this)">
                            </div>
                            <p id="file-name" class="mt-3 mb-0 text-muted" style="font-size: 0.875rem;">Không có file nào được chọn</p>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-gradient-primary w-100 py-2.5 rounded-3 shadow-sm d-flex align-items-center justify-content-center">
                        <i class="bi bi-upload me-2 fs-5"></i> Bắt đầu Tải lên & Import
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function showFileName(input) {
        const file = input.files[0];
        const fileNameText = document.getElementById('file-name');
        if (file) {
            fileNameText.innerHTML = `<span class="text-success fw-bold"><i class="bi bi-file-check me-1"></i>${file.name}</span> (${(file.size / 1024).toFixed(1)} KB)`;
        } else {
            fileNameText.innerHTML = 'Không có file nào được chọn';
        }
    }
</script>
@endsection
