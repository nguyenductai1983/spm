@extends('layouts.app')

@section('title', 'Chỉnh sửa Container - ' . $container->container_so)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-custom border-0 p-5">
            <h3 class="page-header mb-4"><i class="bi bi-pencil-square text-primary me-2"></i> Chỉnh sửa thông tin Container</h3>
            
            <form action="{{ route('containers.update', $container->id) }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="container_so" class="form-label fw-semibold">Số Container <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="container_so" name="container_so" required placeholder="Ví dụ: TGBU2345678" value="{{ old('container_so', $container->container_so) }}">
                    @error('container_so') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="kich_co" class="form-label fw-semibold">Kích cỡ <span class="text-danger">*</span></label>
                    <select class="form-select" id="kich_co" name="kich_co" required>
                        <option value="40'HC" {{ old('kich_co', $container->kich_co) == "40'HC" ? 'selected' : '' }}>40'HC</option>
                        <option value="20'GP" {{ old('kich_co', $container->kich_co) == "20'GP" ? 'selected' : '' }}>20'GP</option>
                        <option value="45'HC" {{ old('kich_co', $container->kich_co) == "45'HC" ? 'selected' : '' }}>45'HC</option>
                        <option value="LCL" {{ old('kich_co', $container->kich_co) == 'LCL' ? 'selected' : '' }}>LCL (Hàng lẻ)</option>
                    </select>
                    @error('kich_co') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="mb-3">
                    <label for="chi_tiet_hang_hoa_id" class="form-label fw-semibold">Model hàng hóa <span class="text-danger">*</span></label>
                    <select class="form-select" id="chi_tiet_hang_hoa_id" name="chi_tiet_hang_hoa_id" required>
                        <option value="">-- Chọn Model --</option>
                        @foreach($container->thongBaoXuatHang->chiTietHangHoas as $item)
                            <option value="{{ $item->id }}" {{ old('chi_tiet_hang_hoa_id', $container->chi_tiet_hang_hoa_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->model }} (TK: {{ $item->so_luong_tham_khao }} {{ $item->selected_type_num->label() }})
                            </option>
                        @endforeach
                    </select>
                    @error('chi_tiet_hang_hoa_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="so_luong" class="form-label fw-semibold">Số lượng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="so_luong" name="so_luong" required placeholder="Ví dụ: 150" value="{{ old('so_luong', $container->so_luong) }}">
                    @error('so_luong') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="tu" class="form-label fw-semibold">Từ số <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tu" name="tu" required placeholder="1" value="{{ old('tu', $container->tu) }}">
                        @error('tu') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-6 mb-3">
                        <label for="den" class="form-label fw-semibold">Đến số <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="den" name="den" required placeholder="150" value="{{ old('den', $container->den) }}">
                        @error('den') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="ghi_chu" class="form-label fw-semibold">Ghi chú</label>
                    <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="2" placeholder="Ghi chú thêm...">{{ old('ghi_chu', $container->ghi_chu) }}</textarea>
                    @error('ghi_chu') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('thong-bao.containers', $container->thong_bao_xuat_hang_id) }}" class="btn btn-outline-secondary px-4">Hủy</a>
                    <button type="submit" class="btn btn-gradient-primary px-4">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
