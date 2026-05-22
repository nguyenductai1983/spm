@extends('layouts.app')

@php
    $isEdit = isset($thongBao) && $thongBao->id > 0;
@endphp

@section('title', $isEdit ? 'Chỉnh sửa Thông báo xuất hàng' : 'Bước 1: Tạo Phiếu & Chi tiết Hàng hóa')

@section('content')
<div class="card card-custom border-0 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="page-header mb-1">{{ $isEdit ? 'Chỉnh sửa Thông báo xuất hàng' : 'Bước 1: Tạo Phiếu & Chi tiết Hàng hóa' }}</h2>
            <p class="text-muted mb-0">
                {{ $isEdit ? 'Cập nhật thông tin phiếu xuất hàng và danh sách hàng' : 'Thiết lập thông tin chung và nhập danh sách mặt hàng' }}
            </p>
        </div>
        <a href="{{ route('thong-bao.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3">
            <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Trở về danh sách
        </a>
    </div>
</div>

<form action="{{ $isEdit ? route('thong-bao.edit', $thongBao->id) : route('thong-bao.quick-create') }}" method="POST" id="tbxhForm">
    @csrf

    <!-- PHẦN 1: NỘI DUNG CHUNG -->
    <div class="card card-custom border-0 shadow-sm p-4 mb-4">
        <h5 class="mb-4 text-primary fw-semibold"><i class="bi bi-file-earmark-text-fill me-2"></i>PHẦN 1: NỘI DUNG CHUNG</h5>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label for="khach_hang_id" class="form-label fw-medium">Khách hàng</label>
                <select name="khach_hang_id" id="khach_hang_id" class="form-select @error('khach_hang_id') is-invalid @enderror">
                    <option value="">--- Chọn khách hàng ---</option>
                    @foreach($khachHangs as $kh)
                        <option value="{{ $kh->id }}" {{ old('khach_hang_id', $thongBao->khach_hang_id) == $kh->id ? 'selected' : '' }}>
                            {{ $kh->name }}
                        </option>
                    @endforeach
                </select>
                @error('khach_hang_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="hang_hoa_id" class="form-label fw-medium">Danh mục hàng hóa</label>
                <select name="hang_hoa_id" id="hang_hoa_id" class="form-select @error('hang_hoa_id') is-invalid @enderror">
                    <option value="">--- Chọn danh mục hàng ---</option>
                    @foreach($hangHoas as $hh)
                        <option value="{{ $hh->id }}" {{ old('hang_hoa_id', $thongBao->hang_hoa_id) == $hh->id ? 'selected' : '' }}>
                            {{ $hh->name }}
                        </option>
                    @endforeach
                </select>
                @error('hang_hoa_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="loai_hang" class="form-label fw-medium">Loại hàng</label>
                <input type="text" name="loai_hang" id="loai_hang" class="form-control @error('loai_hang') is-invalid @enderror" value="{{ old('loai_hang', $thongBao->loai_hang) }}">
                @error('loai_hang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="so_luong" class="form-label fw-medium">Số lượng xuất hàng (Tổng số kiện/cuộn)</label>
                <input type="number" name="so_luong" id="so_luong" class="form-control @error('so_luong') is-invalid @enderror" value="{{ old('so_luong', $thongBao->so_luong) }}">
                @error('so_luong')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="ref_no" class="form-label fw-medium">Đơn hàng (REFNO)</label>
                <input type="text" name="ref_no" id="ref_no" class="form-control @error('ref_no') is-invalid @enderror" value="{{ old('ref_no', $thongBao->ref_no) }}">
                @error('ref_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="po_no" class="form-label fw-medium">Số PO (PoNo)</label>
                <input type="text" name="po_no" id="po_no" class="form-control @error('po_no') is-invalid @enderror" value="{{ old('po_no', $thongBao->po_no) }}">
                @error('po_no')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="ngay_du_kien" class="form-label fw-medium">Ngày dự kiến</label>
                <input type="date" name="ngay_du_kien" id="ngay_du_kien" class="form-control @error('ngay_du_kien') is-invalid @enderror" value="{{ old('ngay_du_kien', $thongBao->ngay_du_kien ? $thongBao->ngay_du_kien->format('Y-m-d') : '') }}">
                @error('ngay_du_kien')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="ngay_etd" class="form-label fw-medium">Ngày ETD</label>
                <input type="date" name="ngay_etd" id="ngay_etd" class="form-control @error('ngay_etd') is-invalid @enderror" value="{{ old('ngay_etd', $thongBao->ngay_etd ? $thongBao->ngay_etd->format('Y-m-d') : '') }}">
                @error('ngay_etd')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12">
                <label for="ghi_chu" class="form-label fw-medium">Ghi chú phiếu</label>
                <textarea name="ghi_chu" id="ghi_chu" rows="2" class="form-control">{{ old('ghi_chu', $thongBao->ghi_chu) }}</textarea>
            </div>
        </div>
    </div>

    <!-- PHẦN 2: CHI TIẾT HÀNG HÓA -->
    <div class="card card-custom border-0 shadow-sm p-4 mb-4">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <h5 class="mb-0 text-primary fw-semibold"><i class="bi bi-list-stars me-2"></i>PHẦN 2: CHI TIẾT HÀNG HÓA</h5>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-gradient-success px-3" id="addChiTietRow">
                    <i class="bi bi-plus-circle me-1"></i> Thêm dòng
                </button>
                <button type="button" class="btn btn-sm btn-gradient-primary px-3" data-bs-toggle="modal" data-bs-target="#excelImportModal">
                    <i class="bi bi-clipboard-data me-1"></i> Nhập từ Excel (Dán)
                </button>
            </div>
        </div>

        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-bordered table-hover align-middle" id="chiTietTable">
                <thead class="table-light sticky-top">
                    <tr>
                        <th style="min-width: 120px;">MODEL</th>
                        <th style="min-width: 100px;">SIZE</th>
                        <th style="min-width: 80px;">Số lượng</th>
                        <th style="min-width: 130px;">Loại ĐG</th>
                        <th style="min-width: 70px;">NW (kg)</th>
                        <th style="min-width: 70px;">GW (kg)</th>
                        <th style="min-width: 70px;">Dài (m)</th>
                        <th style="min-width: 70px;">Rộng (m)</th>
                        <th style="min-width: 70px;">Cao (m)</th>
                        <th style="min-width: 80px;">Màu</th>
                        <th style="min-width: 150px;">Nội dung MR</th>
                        <th style="min-width: 100px;">Lô (LotNo)</th>
                        <th style="min-width: 120px;">QUANTITY</th>
                        <th class="text-center" style="width: 50px;">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @if(old('ChiTietList') || ($isEdit && $thongBao->chiTietHangHoas->count() > 0))
                        @php
                            $items = old('ChiTietList', $thongBao->chiTietHangHoas);
                        @endphp
                        @foreach($items as $index => $item)
                            @php
                                $itemId = is_array($item) ? ($item['ID'] ?? 0) : $item->id;
                                $model = is_array($item) ? ($item['MODEL'] ?? '') : $item->model;
                                $size = is_array($item) ? ($item['SIZE'] ?? '') : $item->size;
                                $sl = is_array($item) ? ($item['SoLuongThamKhao'] ?? 0) : $item->so_luong_tham_khao;
                                $typeNum = is_array($item) ? ($item['SelectedTypeNum'] ?? 0) : ($item->selected_type_num?->value ?? 0);
                                $nw = is_array($item) ? ($item['NW'] ?? '') : $item->nw;
                                $gw = is_array($item) ? ($item['GW'] ?? '') : $item->gw;
                                $dai = is_array($item) ? ($item['Dai'] ?? '') : $item->dai;
                                $rong = is_array($item) ? ($item['Rong'] ?? '') : $item->rong;
                                $cao = is_array($item) ? ($item['Cao'] ?? '') : $item->cao;
                                $color = is_array($item) ? ($item['COLOR'] ?? '') : $item->color;
                                $ext = is_array($item) ? ($item['ExtendedContent'] ?? '') : $item->extended_content;
                                $lot = is_array($item) ? ($item['LotNo'] ?? '') : $item->lot_no;
                                $qty = is_array($item) ? ($item['QUANTITY'] ?? '') : $item->quantity;
                            @endphp
                            <tr>
                                <input type="hidden" name="ChiTietList[{{ $index }}][ID]" value="{{ $itemId }}">
                                <td><input type="text" name="ChiTietList[{{ $index }}][MODEL]" class="form-control form-control-sm" value="{{ $model }}"></td>
                                <td><input type="text" name="ChiTietList[{{ $index }}][SIZE]" class="form-control form-control-sm" value="{{ $size }}"></td>
                                <td><input type="number" name="ChiTietList[{{ $index }}][SoLuongThamKhao]" class="form-control form-control-sm" value="{{ $sl }}"></td>
                                <td>
                                    <select name="ChiTietList[{{ $index }}][SelectedTypeNum]" class="form-select form-select-sm">
                                        <option value="0" {{ $typeNum == 0 ? 'selected' : '' }}>ROLL NO.</option>
                                        <option value="1" {{ $typeNum == 1 ? 'selected' : '' }}>PACKAGE NO.</option>
                                        <option value="2" {{ $typeNum == 2 ? 'selected' : '' }}>BUNDLE NO.</option>
                                    </select>
                                </td>
                                <td><input type="text" name="ChiTietList[{{ $index }}][NW]" class="form-control form-control-sm" value="{{ $nw }}"></td>
                                <td><input type="text" name="ChiTietList[{{ $index }}][GW]" class="form-control form-control-sm" value="{{ $gw }}"></td>
                                <td><input type="number" step="0.001" name="ChiTietList[{{ $index }}][Dai]" class="form-control form-control-sm" value="{{ (float)$dai ?: '' }}"></td>
                                <td><input type="number" step="0.001" name="ChiTietList[{{ $index }}][Rong]" class="form-control form-control-sm" value="{{ (float)$rong ?: '' }}"></td>
                                <td><input type="number" step="0.001" name="ChiTietList[{{ $index }}][Cao]" class="form-control form-control-sm" value="{{ (float)$cao ?: '' }}"></td>
                                <td><input type="text" name="ChiTietList[{{ $index }}][COLOR]" class="form-control form-control-sm" value="{{ $color }}"></td>
                                <td><input type="text" name="ChiTietList[{{ $index }}][ExtendedContent]" class="form-control form-control-sm" value="{{ $ext }}"></td>
                                <td><input type="text" name="ChiTietList[{{ $index }}][LotNo]" class="form-control form-control-sm" value="{{ $lot }}"></td>
                                <td><input type="text" name="ChiTietList[{{ $index }}][QUANTITY]" class="form-control form-control-sm" value="{{ $qty }}"></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="deleteRow(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm mb-4">
            <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Vui lòng sửa các lỗi sau:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-gradient-primary btn-lg px-5 py-3 rounded-3 shadow">
            <i class="bi bi-save me-2"></i>Lưu và Tiếp tục
        </button>
        <a href="{{ route('thong-bao.index') }}" class="btn btn-outline-secondary btn-lg px-5 py-3 rounded-3 ms-2">
            Quay lại
        </a>
    </div>
</form>

<!-- Bảng phụ ẩn chứa template dòng để clone bằng JS -->
<table style="display:none">
    <tr id="chiTietTemplateRow">
        <input type="hidden" name="ChiTietList[!INDEX!][ID]" value="0" />
        <td><input class="form-control form-control-sm" type="text" name="ChiTietList[!INDEX!][MODEL]" /></td>
        <td><input class="form-control form-control-sm" type="text" name="ChiTietList[!INDEX!][SIZE]" /></td>
        <td><input class="form-control form-control-sm" type="number" name="ChiTietList[!INDEX!][SoLuongThamKhao]" /></td>
        <td>
            <select name="ChiTietList[!INDEX!][SelectedTypeNum]" class="form-select form-select-sm">
                <option value="0">ROLL NO.</option>
                <option value="1">PACKAGE NO.</option>
                <option value="2">BUNDLE NO.</option>
            </select>
        </td>
        <td><input class="form-control form-control-sm" type="text" name="ChiTietList[!INDEX!][NW]" /></td>
        <td><input class="form-control form-control-sm" type="text" name="ChiTietList[!INDEX!][GW]" /></td>
        <td><input class="form-control form-control-sm" type="number" step="0.001" name="ChiTietList[!INDEX!][Dai]" /></td>
        <td><input class="form-control form-control-sm" type="number" step="0.001" name="ChiTietList[!INDEX!][Rong]" /></td>
        <td><input class="form-control form-control-sm" type="number" step="0.001" name="ChiTietList[!INDEX!][Cao]" /></td>
        <td><input class="form-control form-control-sm" type="text" name="ChiTietList[!INDEX!][COLOR]" /></td>
        <td><input class="form-control form-control-sm" type="text" name="ChiTietList[!INDEX!][ExtendedContent]" /></td>
        <td><input class="form-control form-control-sm" type="text" name="ChiTietList[!INDEX!][LotNo]" /></td>
        <td><input class="form-control form-control-sm" type="text" name="ChiTietList[!INDEX!][QUANTITY]" /></td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="deleteRow(this)">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
</table>

<!-- Hộp thoại Modal dán dữ liệu Excel -->
<div class="modal fade" id="excelImportModal" tabindex="-1" aria-labelledby="excelImportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-dark text-white py-3" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h5 class="modal-title" id="excelImportModalLabel"><i class="bi bi-clipboard-plus me-2"></i>Dán dữ liệu từ Excel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-warning py-2 mb-3">
                    <p class="mb-1 fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Quy tắc copy-paste:</p>
                    <p class="mb-0 fs-7">Sao chép các cột từ Excel theo đúng thứ tự sau (bao gồm cả dòng dữ liệu, phân cách bằng phím Tab) rồi dán vào ô nhập liệu:</p>
                    <code class="d-block bg-white p-2 border rounded font-monospace mt-2 text-dark" style="font-size: 0.8rem;">
                        MODEL | SIZE | Số lượng kiện | Số lượng cuộn | NW | GW | Dài (m) | Rộng (m) | Cao (m) | Màu | Nội dung MR | Lô | QUANTITY
                    </code>
                </div>
                <textarea id="excelPasteArea" class="form-control font-monospace p-3" rows="12" placeholder="Nhấn Ctrl+V tại đây để dán dữ liệu bảng từ Excel..." style="font-size: 0.85rem; border-radius: 12px;"></textarea>
            </div>
            <div class="modal-footer bg-light py-2">
                <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Hủy bỏ</button>
                <button type="button" class="btn btn-primary px-4 rounded-3 btn-gradient-primary" id="processPasteData">Thêm Dữ Liệu</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateRowIndexes() {
        const tableBody = document.querySelector('#chiTietTable tbody');
        const rows = tableBody.getElementsByTagName('tr');
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            row.querySelectorAll('input, select').forEach(control => {
                if (control.name) {
                    control.name = control.name.replace(/ChiTietList\[\d+\]/, `ChiTietList[${i}]`);
                }
            });
        }
    }

    function deleteRow(btn) {
        btn.closest('tr').remove();
        updateRowIndexes();
    }

    function addRowWithData(data) {
        const tableBody = document.querySelector('#chiTietTable tbody');
        const templateRow = document.getElementById('chiTietTemplateRow');
        const newIndex = tableBody.getElementsByTagName('tr').length;

        const newRow = tableBody.insertRow();
        newRow.innerHTML = templateRow.innerHTML.replace(/!INDEX!/g, newIndex);

        const inputs = newRow.querySelectorAll('input, select');

        if (data) {
            console.log("Raw Excel Row data:", data);

            let soLuong = '0';
            let selectedTypeNum = 0; // Default is ROLLNO

            const packageQtyStr = (data[2] || "").trim();
            const rollQtyStr = (data[3] || "").trim();
            console.log(`Parsed text -> PkgQty: '${packageQtyStr}', RollQty: '${rollQtyStr}'`);

            const packageQty = parseInt(packageQtyStr, 10) || 0;
            const rollQty = parseInt(rollQtyStr, 10) || 0;
            console.log(`Numeric parsed -> PkgQty: ${packageQty}, RollQty: ${rollQty}`);

            if (packageQty > 0) {
                soLuong = packageQty.toString();
                selectedTypeNum = 1; // PACKAGENO
                console.log("==> Identified PACKAGENO");
            } else if (rollQty > 0) {
                soLuong = rollQty.toString();
                selectedTypeNum = 0; // ROLLNO
                console.log("==> Identified ROLLNO");
            }

            inputs[1].value = data[0] || ''; // MODEL
            inputs[2].value = data[1] || ''; // SIZE
            inputs[3].value = soLuong;       // SoLuongThamKhao
            
            const selectElement = inputs[4]; // SelectedTypeNum
            selectElement.value = selectedTypeNum;
            
            inputs[5].value = data[4] || ''; // NW
            inputs[6].value = data[5] || ''; // GW
            inputs[7].value = data[6] || ''; // Dai
            inputs[8].value = data[7] || ''; // Rong
            inputs[9].value = data[8] || ''; // Cao
            inputs[10].value = data[9] || ''; // COLOR
            inputs[11].value = data[10] || ''; // ExtendedContent
            inputs[12].value = data[11] || ''; // LotNo
            inputs[13].value = data[12] || ''; // QUANTITY
        }
    }

    document.getElementById('addChiTietRow').addEventListener('click', function () {
        addRowWithData(null);
        updateRowIndexes();
    });

    document.getElementById('processPasteData').addEventListener('click', function () {
        const pasteData = document.getElementById('excelPasteArea').value.trim();
        if (!pasteData) {
            alert('Vui lòng dán dữ liệu trước.');
            return;
        }
        const rows = pasteData.split('\n');
        rows.forEach(rowText => {
            if (rowText.trim() !== '') {
                const cells = rowText.split('\t');
                addRowWithData(cells);
            }
        });
        updateRowIndexes();
        document.getElementById('excelPasteArea').value = '';
        const modalEl = document.getElementById('excelImportModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
    });
</script>
@endsection
