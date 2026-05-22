@extends('layouts.app')

@section('title', 'Xóa Container - ' . $container->container_so)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card card-custom border-0 p-5 text-center">
            <div class="rounded-circle bg-danger-subtle text-danger mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                <i class="bi bi-exclamation-triangle fs-2"></i>
            </div>
            
            <h3 class="fw-bold mb-3">Xác nhận xóa Container?</h3>
            <p class="text-muted mb-4">
                Bạn có chắc chắn muốn xóa phân phối container <strong>{{ $container->container_so }}</strong> ({{ $container->kich_co }}) cho sản phẩm <strong>{{ $container->chiTietHangHoa?->model ?? '-' }}</strong>? Hành động này không thể hoàn tác.
            </p>
            
            <form action="{{ route('containers.delete', $container->id) }}" method="POST">
                @csrf
                @method('DELETE')
                
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('thong-bao.containers', $thongBaoId) }}" class="btn btn-outline-secondary px-4">Hủy bỏ</a>
                    <button type="submit" class="btn btn-danger px-4">Xóa ngay</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
