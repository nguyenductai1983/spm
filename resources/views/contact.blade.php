@extends('layouts.app')

@section('title', 'Liên hệ')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-custom border-0 p-5">
            <h2 class="page-header mb-4">Thông tin liên hệ</h2>
            
            <div class="row mt-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h5 class="fw-bold"><i class="bi bi-geo-alt-fill text-primary me-2"></i> Văn phòng làm việc</h5>
                    <address class="text-muted ps-4">
                        Agrina Co., Ltd.<br>
                        Đường Số 3, KCN Nhơn Trạch<br>
                        Đồng Nai, Việt Nam
                    </address>
                </div>
                <div class="col-md-6">
                    <h5 class="fw-bold"><i class="bi bi-envelope-at-fill text-success me-2"></i> Kênh hỗ trợ</h5>
                    <ul class="list-unstyled ps-4 text-muted">
                        <li class="mb-2"><strong>Hỗ trợ kỹ thuật:</strong> <a href="mailto:support@agrina.com">support@agrina.com</a></li>
                        <li><strong>Bộ phận kinh doanh:</strong> <a href="mailto:sales@agrina.com">sales@agrina.com</a></li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4 text-slate-300">
            
            <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-0" role="alert">
                <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                <div>
                    Nếu gặp bất kỳ sự cố nào về hệ thống in ấn hoặc import Excel, vui lòng gửi phản hồi kèm file log và ảnh chụp màn hình đến email hỗ trợ kỹ thuật của chúng tôi.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
