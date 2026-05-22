@extends('layouts.app')

@section('title', 'Trang chủ')

@section('styles')
<style>
    .welcome-hero {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: var(--border-radius);
        padding: 3.5rem 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--card-shadow);
    }
    .welcome-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(96, 165, 250, 0.15) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%;
    }
    .welcome-hero::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(167, 139, 250, 0.1) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%;
    }
    .stat-badge {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 30px;
        background-color: rgba(255,255,255,0.1);
        backdrop-filter: blur(4px);
    }
</style>
@endsection

@section('content')
<div class="row mb-5">
    <div class="col-12">
        <div class="welcome-hero text-white text-center position-relative">
            <h1 class="display-4 fw-bold mb-3" style="background: linear-gradient(135deg, #60a5fa 0%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Shipping Mark Management
            </h1>
            <p class="lead text-slate-300 fs-5 max-w-xl mx-auto mb-4">
                Hệ thống quản lý, đóng gói nhãn vận chuyển (Shipping Mark), phân chia container và báo cáo chuyên nghiệp.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <span class="stat-badge text-info"><i class="bi bi-box-seam me-1"></i> {{ $stats['chi_tiets_count'] }} Dòng Chi Tiết</span>
                <span class="stat-badge text-warning"><i class="bi bi-file-earmark-text me-1"></i> {{ $stats['thong_bao_count'] }} Thông Báo Xuất Hàng</span>
                <span class="stat-badge text-success"><i class="bi bi-people me-1"></i> {{ $stats['khach_hang_count'] }} Khách Hàng</span>
            </div>
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    <!-- Card 1: Danh sách SM -->
    <div class="col">
        <div class="card card-custom h-100 border-0 p-4">
            <div class="card-body d-flex flex-column text-center">
                <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                    <i class="bi bi-list-ul fs-2"></i>
                </div>
                <h4 class="card-title fw-bold mb-3">Danh sách Shipping Mark</h4>
                <p class="card-text text-muted mb-4">
                    Quản lý danh sách các dòng Shipping Mark đã import riêng lẻ. Xem thông tin in ấn, trạng thái và cập nhật chi tiết.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('chi-tiets.index') }}" class="btn btn-gradient-primary w-100 rounded-pill py-2">
                        Truy cập ngay <i class="bi bi-arrow-right-short ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2: Thông Báo Xuất Hàng -->
    <div class="col">
        <div class="card card-custom h-100 border-0 p-4" style="border-top: 4px solid #f59e0b !important;">
            <div class="card-body d-flex flex-column text-center">
                <div class="rounded-circle bg-warning-subtle text-warning mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                    <i class="bi bi-truck fs-2"></i>
                </div>
                <h4 class="card-title fw-bold mb-3">Thông Báo Xuất Hàng</h4>
                <p class="card-text text-muted mb-4">
                    Quy trình tạo phiếu xuất hàng thông minh qua Clipboard Excel, chia container tự động và in báo cáo chuẩn A4.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('thong-bao.index') }}" class="btn btn-gradient-success w-100 rounded-pill py-2">
                        Quản lý phiếu <i class="bi bi-arrow-right-short ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3: Import Excel -->
    <div class="col">
        <div class="card card-custom h-100 border-0 p-4">
            <div class="card-body d-flex flex-column text-center">
                <div class="rounded-circle bg-info-subtle text-info mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                    <i class="bi bi-file-earmark-excel fs-2"></i>
                </div>
                <h4 class="card-title fw-bold mb-3">Import Excel</h4>
                <p class="card-text text-muted mb-4">
                    Nhập dữ liệu Shipping Mark hàng loạt từ tệp Excel mẫu để rút ngắn thời gian chuẩn bị và in nhãn dán.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('chi-tiet.import') }}" class="btn btn-outline-info w-100 rounded-pill py-2">
                        Import ngay <i class="bi bi-upload ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4: Quản lý Khách hàng -->
    <div class="col">
        <div class="card card-custom h-100 border-0 p-4">
            <div class="card-body d-flex flex-column text-center">
                <div class="rounded-circle bg-success-subtle text-success mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                    <i class="bi bi-person-badge fs-2"></i>
                </div>
                <h4 class="card-title fw-bold mb-3">Khách Hàng</h4>
                <p class="card-text text-muted mb-4">
                    Xem và thiết lập cơ sở dữ liệu đối tác, khách hàng phục vụ cho quy trình dán nhãn và xuất hàng.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('khach-hangs.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2">
                        Xem danh sách <i class="bi bi-arrow-right-short ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 5: Quản lý Hàng hóa -->
    <div class="col">
        <div class="card card-custom h-100 border-0 p-4">
            <div class="card-body d-flex flex-column text-center">
                <div class="rounded-circle bg-secondary-subtle text-secondary mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                    <i class="bi bi-box-seam fs-2"></i>
                </div>
                <h4 class="card-title fw-bold mb-3">Hàng Hóa</h4>
                <p class="card-text text-muted mb-4">
                    Quản lý danh mục các loại hàng hóa trong hệ thống và thông tin chi tiết từng sản phẩm.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('hang-hoas.index') }}" class="btn btn-outline-secondary w-100 rounded-pill py-2">
                        Xem danh mục <i class="bi bi-arrow-right-short ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 6: Quản lý Thành viên (Admin) -->
    @if(auth()->user()->role === 'admin')
    <div class="col">
        <div class="card card-custom h-100 border-0 p-4" style="border-top: 4px solid #ef4444 !important;">
            <div class="card-body d-flex flex-column text-center">
                <div class="rounded-circle bg-danger-subtle text-danger mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                    <i class="bi bi-people fs-2"></i>
                </div>
                <h4 class="card-title fw-bold mb-3">Quản Lý Thành Viên</h4>
                <p class="card-text text-muted mb-4">
                    Chức năng admin quản trị người dùng: thêm tài khoản mới, phân quyền truy cập, chỉnh sửa thông tin hoặc đặt lại mật khẩu.
                </p>
                <div class="mt-auto">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-danger w-100 rounded-pill py-2">
                        Quản trị hệ thống <i class="bi bi-gear ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
