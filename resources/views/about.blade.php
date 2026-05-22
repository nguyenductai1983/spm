@extends('layouts.app')

@section('title', 'Giới thiệu')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 p-5">
            <h2 class="page-header mb-4">Giới thiệu về hệ thống</h2>
            <p class="lead text-muted">
                Hệ thống Quản lý Shipping Mark (SM) cung cấp giải pháp toàn diện cho việc đóng gói, theo dõi nhãn vận chuyển và quản lý container xuất khẩu.
            </p>
            <p>
                Được phát triển với mục đích tối ưu hóa quy trình làm việc từ khâu chuẩn bị chứng từ đến khi xếp dỡ hàng lên container thực tế. Hệ thống giúp kết nối thông tin giữa khách hàng, hàng hóa, quy cách đóng gói và vị trí container một cách trực quan, chính xác.
            </p>
            <hr class="my-4 text-slate-300">
            <h4 class="fw-bold mb-3">Các tính năng cốt lõi:</h4>
            <ul>
                <li class="mb-2"><strong>Import Excel nhanh chóng:</strong> Import hàng loạt thông tin nhãn dán từ các file bảng tính chuẩn.</li>
                <li class="mb-2"><strong>Parse dữ liệu clipboard:</strong> Copy trực tiếp bảng dữ liệu từ Excel và dán trực tiếp vào wizard tạo phiếu một cách thông minh.</li>
                <li class="mb-2"><strong>Quản lý Container & Định vị số kiện:</strong> Sắp xếp chính xác dải số cuộn/số kiện (Từ - Đến) của từng mã hàng trên container tương ứng.</li>
                <li class="mb-2"><strong>Xuất báo cáo PDF chất lượng cao:</strong> Báo cáo in ấn tối ưu và xuất file PDF phục vụ lưu trữ hoặc đính kèm.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
