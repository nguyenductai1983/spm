@php
    $isPdf = request()->is('*/pdf') || request()->segment(3) === 'pdf' || request()->segment(2) === 'pdf';
    $logoPath = $isPdf ? public_path('images/logo.png') : asset('images/logo.png');
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title>Thông Báo Xuất Hàng - {{ $thongBao->po_no }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000000;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px;
            vertical-align: top;
            border: none;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 10pt;
            margin-bottom: 20px;
        }

        .main-table th, .main-table td {
            border: 1px solid #000000;
            padding: 6px 4px;
            vertical-align: middle;
        }

        .main-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .total-row td {
            font-weight: bold;
            background-color: #fafafa;
        }

        .text-left {
            text-align: left;
        }

        .text-red {
            color: #ff0000;
        }

        .group-header {
            font-weight: bold;
            text-align: left;
            padding: 15px 0 5px 0;
            font-size: 12pt;
        }

        .footer-container {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        .footer-table td {
            border: none;
            padding: 0;
        }

        .footer-left {
            width: 50%;
            text-align: left;
            vertical-align: top;
            font-weight: bold;
            font-style: italic;
            font-size: 10pt;
        }

        .footer-right {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        /* Action Buttons styling */
        .button-container {
            padding: 15px 20px;
            text-align: right;
            position: fixed;
            top: 15px;
            right: 20px;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .action-button {
            display: inline-block;
            background-color: #3b82f6;
            color: #ffffff;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            margin-left: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: background-color 0.15s;
        }

        .action-button:hover {
            background-color: #2563eb;
        }

        .action-button.btn-pdf {
            background-color: #10b981;
        }

        .action-button.btn-pdf:hover {
            background-color: #059669;
        }

        .action-button.btn-back {
            background-color: #64748b;
        }

        .action-button.btn-back:hover {
            background-color: #475569;
        }

        /* Auto-hide action buttons during standard print */
        @media print {
            .button-container {
                display: none !important;
            }
            .container {
                width: 100%;
                padding: 0;
                margin: 0;
            }
            body {
                font-size: 10pt;
            }
        }
        
        @page {
            size: A4 landscape;
            margin: 1.2cm;
        }
    </style>
</head>

<body>
    @if(!$isPdf)
        <div class="button-container">
            <a href="{{ route('thong-bao.containers', $thongBao->id) }}" class="action-button btn-back">🎛️ Quản lý Container</a>
            <button class="action-button" onclick="window.print()">🖨️ In Trang Này</button>
            <a href="{{ route('thong-bao.pdf', $thongBao->id) }}" class="action-button btn-pdf">📄 Tải PDF</a>
        </div>
    @endif

    <div class="container">
        <!-- Logo and Title -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: none;">
            <tr>
                <td style="width: 25%; text-align: left; border: none; vertical-align: middle;">
                    @if(file_exists($logoPath) || !$isPdf)
                        <img src="{{ $logoPath }}" alt="Logo" style="max-width: 180px; max-height: 90px; object-fit: contain;" />
                    @else
                        <div style="font-weight: bold; font-size: 14pt; color: #475569;">AGRINA</div>
                    @endif
                </td>
                <td style="width: 50%; text-align: center; border: none; vertical-align: middle;">
                    <h2 style="font-size: 19pt; margin: 0; font-weight: bold; letter-spacing: 0.5px;">THÔNG BÁO XUẤT HÀNG</h2>
                </td>
                <td style="width: 25%; border: none;"></td>
            </tr>
        </table>

        <!-- Notice Metadata -->
        <table class="info-table">
            <tr>
                <td style="width: 15%;"><b>Loại hàng:</b></td>
                <td style="width: 35%;">{{ $thongBao->loai_hang }}</td>
                <td style="width: 20%;"><b>Tổng số kiện/cuộn:</b></td>
                <td style="width: 30%;">
                    @php
                        $totalPackages = 0;
                        $totalRolls = 0;
                        foreach ($thongBao->containers as $container) {
                            $qty = (int)$container->so_luong;
                            if ($container->chiTietHangHoa?->selected_type_num === \App\Enums\TypeNum::PACKAGENO) {
                                $totalPackages += $qty;
                            } elseif ($container->chiTietHangHoa?->selected_type_num === \App\Enums\TypeNum::ROLLNO) {
                                $totalRolls += $qty;
                            }
                        }
                    @endphp
                    @if ($totalPackages > 0)
                        <b>{{ $totalPackages }} kiện</b>
                    @endif
                    @if ($totalRolls > 0)
                        @if ($totalPackages > 0) & @endif
                        <b>{{ $totalRolls }} cuộn</b>
                    @endif
                    @if ($totalPackages == 0 && $totalRolls == 0)
                        <b>0</b>
                    @endif
                </td>
            </tr>
            <tr>
                <td><b>Đơn hàng:</b></td>
                <td>{{ $thongBao->ref_no }}</td>
                <td><b>Ngày xuất hàng dự kiến:</b></td>
                <td class="text-red"><b>{{ \Carbon\Carbon::parse($thongBao->ngay_du_kien)->format('d/m/Y') }}</b></td>
            </tr>
            <tr>
                <td><b>Số PO:</b></td>
                <td>{{ $thongBao->po_no }}</td>
                <td><b>ETD:</b></td>
                <td class="text-red"><b>{{ \Carbon\Carbon::parse($thongBao->ngay_etd)->format('d/m/Y') }}</b></td>
            </tr>
        </table>

        <!-- Consolidated Table of Loaded Goods -->
        <table class="main-table">
            <thead>
                <tr>
                    <th rowspan="2">Model</th>
                    <th rowspan="2">Kích thước lưới</th>
                    <th rowspan="2">Số kiện</th>
                    <th rowspan="2">Số cuộn</th>
                    <th colspan="2">Trọng lượng (cuộn/kgs)</th>
                    <th colspan="3">Kích thước cuộn (m)</th>
                    <th rowspan="2">Màu (Color)</th>
                    <th rowspan="2">Nội dung mở rộng</th>
                </tr>
                <tr>
                    <th>Net weight</th>
                    <th>Gross weight</th>
                    <th>Dài</th>
                    <th>Rộng</th>
                    <th>Cao</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedByIFT = $thongBao->containers->groupBy('chi_tiet_hang_hoa_id');
                    $grandTotalPackages = 0;
                    $grandTotalRolls = 0;
                @endphp
                @forelse($groupedByIFT as $chiTietHangHoaId => $allocations)
                    @php
                        $item = $allocations->first()->chiTietHangHoa;
                        $loadedQty = $allocations->sum(function($c) { return (int)$c->so_luong; });
                        
                        $isPackage = $item && $item->selected_type_num === \App\Enums\TypeNum::PACKAGENO;
                        $isRoll = $item && $item->selected_type_num === \App\Enums\TypeNum::ROLLNO;
                        
                        if ($isPackage) { $grandTotalPackages += $loadedQty; }
                        if ($isRoll) { $grandTotalRolls += $loadedQty; }
                    @endphp
                    @if($item)
                        <tr>
                            <td class="text-left" style="font-weight: 550;">{{ $item->model }}</td>
                            <td>{{ $item->size }}</td>
                            <td>{{ $isPackage ? $loadedQty : 0 }}</td>
                            <td>{{ $isRoll ? $loadedQty : 0 }}</td>
                            <td>{{ $item->nw }}</td>
                            <td>{{ $item->gw }}</td>
                            <td>{{ $item->dai !== null ? number_format($item->dai, 2) : '-' }}</td>
                            <td>{{ $item->rong !== null ? number_format($item->rong, 2) : '-' }}</td>
                            <td>{{ $item->cao !== null ? number_format($item->cao, 2) : '-' }}</td>
                            <td>{{ $item->color ?? '-' }}</td>
                            <td class="text-red">{{ $item->extended_content ?? '-' }}</td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="11" class="text-muted">Chưa có chi tiết hàng hóa hoặc container được sắp xếp.</td>
                    </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="2">TỔNG CỘNG</td>
                    <td>{{ $grandTotalPackages }} Kiện</td>
                    <td>{{ $grandTotalRolls }} Cuộn</td>
                    <td colspan="7"></td>
                </tr>
            </tbody>
        </table>

        <!-- Container Breakdown Section -->
        <div style="page-break-inside: avoid;">
            <div class="group-header">Xếp lên container như sau:</div>

            <table class="main-table">
                <thead>
                    <tr>
                        <th rowspan="2">Container số</th>
                        <th rowspan="2">Kích cỡ container</th>
                        <th rowspan="2">Số lượng</th>
                        <th rowspan="2">Model</th>
                        <th colspan="2">STT Kiện/Cuộn</th>
                        <th rowspan="2" style="width: 30%;">Ghi chú</th>
                    </tr>
                    <tr>
                        <th>Từ</th>
                        <th>Đến</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($containerGroups as $group)
                        @php $firstItemInGroup = true; @endphp
                        @foreach($group->items as $item)
                            <tr>
                                @if ($firstItemInGroup)
                                    <td rowspan="{{ count($group->items) }}"><b>{{ $group->container_so }}</b></td>
                                    <td rowspan="{{ count($group->items) }}"><span style="font-size: 9pt;">{{ $group->kich_co }}</span></td>
                                @endif
                                <td style="font-weight: 550;">{{ $item->so_luong }}</td>
                                <td class="text-left">{{ $item->model_name }}</td>
                                <td>{{ $item->tu }}</td>
                                <td>{{ $item->den }}</td>
                                <td class="text-left"><small>{{ $item->ghi_chu ?? '-' }}</small></td>
                            </tr>
                            @php $firstItemInGroup = false; @endphp
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">Chưa có thông tin xếp container.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Signatures -->
        <div class="footer-container">
            <table class="footer-table">
                <tr>
                    <td class="footer-left">
                        - BP. Kho.<br />
                        - PX. May.<br />
                        - BP. thống kê.<br />
                        - BP. XNK.<br />
                        - Lưu
                    </td>
                    <td class="footer-right">
                        <i>Ngày {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}</i><br /><br />
                        <b>Người lập</b>
                        <br /><br /><br /><br />
                        <span style="font-weight: bold; text-decoration: underline;">{{ $creatorName }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
