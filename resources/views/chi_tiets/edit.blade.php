@extends('layouts.app')

@section('title', 'Chỉnh sửa Shipping Mark')

@section('content')
<div class="card card-custom border-0 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="page-header mb-1">Chỉnh sửa Shipping Mark</h2>
            <p class="text-muted mb-0">Cập nhật thông tin chi tiết nhãn hàng vận chuyển</p>
        </div>
        <a href="{{ route('chi-tiets.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3">
            <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Trở về danh sách
        </a>
    </div>
</div>

<div class="card card-custom border-0 shadow-sm p-4">
    <form action="{{ route('chi-tiets.update', $chiTiet->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Cột 1: Thông tin cơ bản -->
            <div class="col-lg-4 border-end-lg">
                <h5 class="mb-4 text-primary fw-semibold"><i class="bi bi-info-circle-fill me-2"></i>Thông tin cơ bản</h5>
                
                <div class="mb-3">
                    <label for="ref_no" class="form-label fw-medium text-muted">REFNO (Không thể sửa)</label>
                    <input type="text" id="ref_no" class="form-control bg-light text-muted" value="{{ $chiTiet->thongBaoXuatHang?->ref_no }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="po_no" class="form-label fw-medium text-muted">PoNo (Không thể sửa)</label>
                    <input type="text" id="po_no" class="form-control bg-light text-muted" value="{{ $chiTiet->thongBaoXuatHang?->po_no }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="model" class="form-label fw-medium">MODEL</label>
                    <input type="text" name="model" id="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model', $chiTiet->model) }}">
                    @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="size" class="form-label fw-medium">SIZE</label>
                    <input type="text" name="size" id="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size', $chiTiet->size) }}">
                    @error('size')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-2">
                    <div class="col-6 mb-3">
                        <label for="nw" class="form-label fw-medium">NW (kg)</label>
                        <input type="text" name="nw" id="nw" class="form-control @error('nw') is-invalid @enderror" value="{{ old('nw', $chiTiet->nw) }}">
                        @error('nw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="gw" class="form-label fw-medium">GW (kg)</label>
                        <input type="text" name="gw" id="gw" class="form-control @error('gw') is-invalid @enderror" value="{{ old('gw', $chiTiet->gw) }}">
                        @error('gw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-4 mb-3">
                        <label for="dai" class="form-label fw-medium">Dài (m)</label>
                        <input type="number" step="0.001" name="dai" id="dai" class="form-control @error('dai') is-invalid @enderror" value="{{ old('dai', $chiTiet->dai) }}">
                        @error('dai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4 mb-3">
                        <label for="rong" class="form-label fw-medium">Rộng (m)</label>
                        <input type="number" step="0.001" name="rong" id="rong" class="form-control @error('rong') is-invalid @enderror" value="{{ old('rong', $chiTiet->rong) }}">
                        @error('rong')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-4 mb-3">
                        <label for="cao" class="form-label fw-medium">Cao (m)</label>
                        <input type="number" step="0.001" name="cao" id="cao" class="form-control @error('cao') is-invalid @enderror" value="{{ old('cao', $chiTiet->cao) }}">
                        @error('cao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Cột 2: Thông tin chi tiết in ấn -->
            <div class="col-lg-4 border-end-lg">
                <h5 class="mb-4 text-primary fw-semibold"><i class="bi bi-printer-fill me-2"></i>In ấn & Đóng gói</h5>

                <div class="mb-3">
                    <label for="color" class="form-label fw-medium">COLOR</label>
                    <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $chiTiet->color) }}">
                    @error('color')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label fw-medium text-muted">Type (Trước số nhảy - Tự động theo Enum)</label>
                    <input type="text" id="type" class="form-control bg-light text-muted" value="{{ $chiTiet->selected_type_num?->label() }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="type_suffix" class="form-label fw-medium">Type Suffix (Nội dung sau số nhảy)</label>
                    <input type="text" name="type_suffix" id="type_suffix" class="form-control @error('type_suffix') is-invalid @enderror" value="{{ old('type_suffix', $chiTiet->extended_content) }}">
                    @error('type_suffix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-2">
                    <div class="col-6 mb-3">
                        <label for="start_serial" class="form-label fw-medium">Số bắt đầu</label>
                        <input type="text" name="start_serial" id="start_serial" class="form-control @error('start_serial') is-invalid @enderror" value="{{ old('start_serial', $chiTiet->containers->first()?->tu) }}">
                        @error('start_serial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="num_serial" class="form-label fw-medium">Số lượng in</label>
                        <input type="number" name="num_serial" id="num_serial" class="form-control @error('num_serial') is-invalid @enderror" value="{{ old('num_serial', $chiTiet->containers->first()?->so_luong) }}">
                        @error('num_serial')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="lot_no" class="form-label fw-medium">LotNo</label>
                    <input type="text" name="lot_no" id="lot_no" class="form-control @error('lot_no') is-invalid @enderror" value="{{ old('lot_no', $chiTiet->lot_no) }}">
                    @error('lot_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="selected_type_num" class="form-label fw-medium">Loại đánh số nhảy (Enum)</label>
                    <select name="selected_type_num" id="selected_type_num" class="form-select @error('selected_type_num') is-invalid @enderror">
                        <option value="0" {{ old('selected_type_num', $chiTiet->selected_type_num?->value) === 0 ? 'selected' : '' }}>ROLL NO.</option>
                        <option value="1" {{ old('selected_type_num', $chiTiet->selected_type_num?->value) === 1 ? 'selected' : '' }}>PACKAGE NO.</option>
                        <option value="2" {{ old('selected_type_num', $chiTiet->selected_type_num?->value) === 2 ? 'selected' : '' }}>BUNDLE NO.</option>
                    </select>
                    @error('selected_type_num')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Cột 3: Thông tin khách hàng & Khác -->
            <div class="col-lg-4">
                <h5 class="mb-4 text-primary fw-semibold"><i class="bi bi-person-fill me-2"></i>Khách hàng & Hàng hóa</h5>

                <div class="mb-3">
                    <label for="customer" class="form-label fw-medium text-muted">Tên Khách hàng (Không thể sửa)</label>
                    <input type="text" id="customer" class="form-control bg-light text-muted" value="{{ $chiTiet->thongBaoXuatHang?->khachHang?->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="customer_code" class="form-label fw-medium text-muted">Mã Khách hàng (Không thể sửa)</label>
                    <input type="text" id="customer_code" class="form-control bg-light text-muted" value="{{ $chiTiet->thongBaoXuatHang?->khachHang?->code }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="commodity" class="form-label fw-medium text-muted">Hàng hóa (Không thể sửa)</label>
                    <input type="text" id="commodity" class="form-control bg-light text-muted" value="{{ $chiTiet->thongBaoXuatHang?->hangHoa?->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label fw-medium">Số lượng mặt hàng (QUANTITY)</label>
                    <input type="text" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $chiTiet->quantity) }}">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 pt-3 border-top">
                    <div class="form-check form-switch">
                        <input type="checkbox" name="using_print" value="1" id="usingPrintCheckbox" class="form-check-input" role="switch" {{ old('using_print', $chiTiet->using_print) ? 'checked' : '' }}>
                        <label for="usingPrintCheckbox" class="form-check-label fw-medium text-dark">Đã in xong</label>
                    </div>
                    <span id="printStatus" class="fw-bold {{ $chiTiet->using_print ? 'text-success' : 'text-danger' }}">
                        {{ $chiTiet->using_print ? 'Đã in' : 'Chưa in' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-gradient-primary px-5 py-2.5 rounded-3 me-2">
                    <i class="bi bi-save me-1"></i> Lưu thay đổi
                </button>
                <a href="{{ route('chi-tiets.index') }}" class="btn btn-outline-secondary px-5 py-2.5 rounded-3">
                    Hủy bỏ
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.getElementById("usingPrintCheckbox");
        const statusSpan = document.getElementById("printStatus");

        checkbox.addEventListener("change", function () {
            if (checkbox.checked) {
                statusSpan.textContent = "Đã in";
                statusSpan.classList.remove("text-danger");
                statusSpan.classList.add("text-success");
            } else {
                statusSpan.textContent = "Chưa in";
                statusSpan.classList.remove("text-success");
                statusSpan.classList.add("text-danger");
            }
        });
    });
</script>
@endsection
