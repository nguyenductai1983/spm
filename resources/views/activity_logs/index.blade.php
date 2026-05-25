@extends('layouts.app')

@section('title', 'Nhật ký thay đổi hệ thống')

@section('content')
<div class="card card-custom border-0 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="page-header mb-1">Nhật ký thay đổi hệ thống</h2>
            <p class="text-muted mb-0">Xem toàn bộ lịch sử chỉnh sửa trên hệ thống</p>
        </div>
    </div>
</div>

<div class="card card-custom border-0 shadow-sm p-4">
    @if($activities->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Thời gian</th>
                        <th>Người thực hiện</th>
                        <th>Hành động</th>
                        <th>Đối tượng</th>
                        <th>Chi tiết thay đổi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        <tr>
                            <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $activity->causer ? ($activity->causer->full_name ?? $activity->causer->name) : 'Hệ thống' }}</td>
                            <td>
                                @if($activity->description === 'created')
                                    <span class="badge bg-success">Tạo mới</span>
                                @elseif($activity->description === 'updated')
                                    <span class="badge bg-warning text-dark">Cập nhật</span>
                                @elseif($activity->description === 'deleted')
                                    <span class="badge bg-danger">Xóa</span>
                                @else
                                    <span class="badge bg-secondary">{{ $activity->description }}</span>
                                @endif
                            </td>
                            <td>
                                @if(class_basename($activity->subject_type) === 'ChiTietHangHoa')
                                    <span class="text-primary fw-medium">Chi tiết Hàng hóa #{{ $activity->subject_id }}</span>
                                    @if($activity->subject)
                                        <div class="small text-muted">Model: {{ $activity->subject->model ?? 'N/A' }}</div>
                                    @endif
                                @elseif(class_basename($activity->subject_type) === 'Container')
                                    <span class="text-info fw-medium">Container #{{ $activity->subject_id }}</span>
                                    @if($activity->subject && $activity->subject->chiTietHangHoa)
                                        <div class="small text-muted">Chi tiết: #{{ $activity->subject->chi_tiet_hang_hoa_id }}</div>
                                    @endif
                                @else
                                    {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                @endif
                            </td>
                            <td>
                                @if($activity->description === 'updated' && $activity->attribute_changes && $activity->attribute_changes->has('attributes') && $activity->attribute_changes->has('old'))
                                    <ul class="mb-0 list-unstyled small">
                                        @foreach($activity->attribute_changes['attributes'] as $key => $value)
                                            @if(array_key_exists($key, $activity->attribute_changes['old']))
                                                @php
                                                    $oldValue = $activity->attribute_changes['old'][$key];
                                                    if ($oldValue == $value) continue;
                                                @endphp
                                                <li>
                                                    <strong>{{ $key }}:</strong> 
                                                    <span class="text-danger text-decoration-line-through">{{ $oldValue ?? 'Trống' }}</span> 
                                                    <i class="bi bi-arrow-right mx-1"></i> 
                                                    <span class="text-success">{{ $value ?? 'Trống' }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted small">Không có dữ liệu</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $activities->links() }}
        </div>
    @else
        <p class="text-muted mb-0">Chưa có thay đổi nào được ghi nhận trên hệ thống.</p>
    @endif
</div>
@endsection
