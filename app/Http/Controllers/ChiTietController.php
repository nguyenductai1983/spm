<?php

namespace App\Http\Controllers;

use App\Enums\TypeNum;
use App\Models\ChiTiet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ChiTietController extends Controller
{
    public function showImport()
    {
        return view('chi_tiet.import');
    }

    public function import(Request $request)
    {
        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return back()->with('error', 'Vui lòng chọn một file Excel hợp lệ để tải lên.');
        }

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, ['xlsx', 'xls'])) {
            return back()->with('error', 'Định dạng file không hợp lệ. Vui lòng chọn file .xlsx hoặc .xls.');
        }

        try {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            $currentUser = Auth::user()->full_name ?? Auth::user()->name;
            $listIft = [];
            $now = now();

            // Row 1 is header, start from row 2
            for ($row = 2; $row <= $highestRow; $row++) {
                // Check if row is empty by checking the first column (REFNO)
                $refNo = $sheet->getCell("A{$row}")->getValue();
                $poNo = $sheet->getCell("B{$row}")->getValue();

                if (empty($refNo) && empty($poNo)) {
                    continue; // Skip empty rows
                }

                // Parse selected_type_num
                $typeNumVal = $sheet->getCell("N{$row}")->getValue();
                $selectedTypeNum = TypeNum::ROLLNO; // Default
                if ($typeNumVal == 1) {
                    $selectedTypeNum = TypeNum::PACKAGENO;
                }

                // Parse using_print
                $usingPrintVal = $sheet->getCell("O{$row}")->getValue();
                $usingPrint = false;
                if (is_bool($usingPrintVal)) {
                    $usingPrint = $usingPrintVal;
                } elseif (is_numeric($usingPrintVal) && $usingPrintVal == 1) {
                    $usingPrint = true;
                }

                // Convert decimals safely
                $dai = $sheet->getCell("H{$row}")->getValue();
                $rong = $sheet->getCell("I{$row}")->getValue();
                $cao = $sheet->getCell("J{$row}")->getValue();

                $listIft[] = [
                    'ref_no' => $refNo ? (string)$refNo : null,
                    'po_no' => $poNo ? (string)$poNo : null,
                    'customer_code' => $sheet->getCell("C{$row}")->getValue(),
                    'model' => $sheet->getCell("D{$row}")->getValue(),
                    'size' => $sheet->getCell("E{$row}")->getValue(),
                    'nw' => $sheet->getCell("F{$row}")->getValue(),
                    'gw' => $sheet->getCell("G{$row}")->getValue(),
                    'dai' => is_numeric($dai) ? (float)$dai : null,
                    'rong' => is_numeric($rong) ? (float)$rong : null,
                    'cao' => is_numeric($cao) ? (float)$cao : null,
                    'color' => $sheet->getCell("K{$row}")->getValue(),
                    'start_serial' => $sheet->getCell("L{$row}")->getValue(),
                    'num_serial' => $sheet->getCell("M{$row}")->getValue(),
                    'selected_type_num' => $selectedTypeNum->value,
                    'using_print' => $usingPrint,
                    'lot_no' => $sheet->getCell("P{$row}")->getValue(),
                    'type' => $sheet->getCell("Q{$row}")->getValue(),
                    'type_suffix' => $sheet->getCell("R{$row}")->getValue(),
                    'customer' => $sheet->getCell("S{$row}")->getValue(),
                    'quantity' => $sheet->getCell("T{$row}")->getValue(),
                    'commodity' => $sheet->getCell("U{$row}")->getValue(),
                    'created_by' => $currentUser,
                    'last_modified_by' => $currentUser,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            // if (count($listIft) > 0) {
            //     DB::transaction(function () use ($listIft) {
            //         ChiTiet::insert($listIft);
            //     });
            //     return redirect()->route('chi-tiets.index')->with('success', 'Thành công! Đã import ' . count($listIft) . ' dòng dữ liệu.');
            // } else {
            //     return back()->with('error', 'Không tìm thấy dòng dữ liệu nào hợp lệ trong file Excel.');
            // }
        } catch (\Exception $ex) {
            return back()->with('error', 'Đã xảy ra lỗi: ' . $ex->getMessage() . '. Vui lòng kiểm tra lại định dạng file Excel.');
        }
    }

    public function exportTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('SM Template');

        $headers = [
            'REFNO',
            'PoNo',
            'Mã PO 3 kí tự',
            'MODEL',
            'SIZE',
            'NW',
            'GW',
            'Dài (m)',
            'Rộng (m)',
            'Cao (m)',
            'COLOR',
            'Số bắt đầu',
            'Số lượng in',
            '0 Cuộn 1 Kiện',
            'In 0 - Không in 1',
            'LotNo',
            'ROLL/PACKAGE No.',
            'Nội dung sau số nhảy',
            'Customer',
            'QUANTITY',
            'COMMODITY'
        ];

        // Write headers
        foreach ($headers as $index => $header) {
            $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
            $sheet->setCellValue("{$colLetter}1", $header);
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        $fileName = 'SM_Template_' . date('YmdHis') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
