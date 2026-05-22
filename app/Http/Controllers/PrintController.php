<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use stdClass;

class PrintController extends Controller
{
    /**
     * 
     * @param mixed $id 
     * @param string $source 
     * @return object|stdClass|null 
     */
    private function getPrintData($id, $source = 'ift')
    {
        if ($source === 'chitiet') {
            $chiTiet = \App\Models\ChiTietHangHoa::with([
                'thongBaoXuatHang.khachHang',
                'thongBaoXuatHang.hangHoa',
                'containers'
            ])->findOrFail($id);
            return (object) [
                'ID' => $chiTiet->id,
                'MODEL' => $chiTiet->model,
                'SIZE' => $chiTiet->size,
                'GW' => $chiTiet->gw,
                'COLOR' => $chiTiet->color,
                'LotNo' => $chiTiet->lot_no,
                'QUANTITY' => $chiTiet->quantity,
                'TypeSuffix' => $chiTiet->extended_content,
                'usingPrint' => $chiTiet->using_print ? 1 : 0,
                'TypeText' => $chiTiet->selected_type_num?->label() ?? 'UNKNOWN',
                'REFNO' => $chiTiet->thongBaoXuatHang?->ref_no,
                'PoNo' => $chiTiet->thongBaoXuatHang?->po_no,
                'Customer' => $chiTiet->thongBaoXuatHang?->khachHang?->name,
                'CustomerCode' => $chiTiet->thongBaoXuatHang?->khachHang?->code,
                'COMMODITY' => $chiTiet->thongBaoXuatHang?->hangHoa?->name,
                'StartSerial' => $chiTiet->containers->first()?->tu,
                'NumSerial' => $chiTiet->containers->first()?->so_luong,
            ];
        }

        return DB::table('IFTs')->where('ID', $id)->first();
    }
    /**
     * 
     * @param Request $request 
     * @param mixed $id 
     * @return View 
     */
    public function select(Request $request, $id)
    {
        $source = $request->get('source', 'ift');
        $data = $this->getPrintData($id, $source);
        if (!$data) {
            abort(404, 'Data not found');
        }

        $templates = [];
        $files = glob(resource_path('views/prints/templates/*.blade.php'));
        foreach ($files as $file) {
            $filename = basename($file, '.blade.php');
            $templates[] = $filename;
        }
        sort($templates);

        return view('prints.select', compact('data', 'id', 'source', 'templates'));
    }
    /**
     * 
     * @param Request $request 
     * @param mixed $id 
     * @return Response 
     */
    public function generate(Request $request, $id)
    {
        $source = $request->get('source', 'ift');
        $data = $this->getPrintData($id, $source);
        if (!$data) {
            abort(404, 'Data not found');
        }

        $templateId = $request->input('template_id');
        $viewName = 'prints.templates.' . $templateId;

        if (!\Illuminate\Support\Facades\View::exists($viewName)) {
            abort(400, 'Invalid template ID');
        }

        // Generate pages for each serial
        $pages = [];
        $startSerial = (int) $data->StartSerial;
        $numSerial = (int) $data->NumSerial;

        // Ensure at least 1 page prints if NumSerial is 0 or null
        if ($numSerial <= 0) {
            $numSerial = 1;
        }

        for ($i = 0; $i < $numSerial; $i++) {
            // $currentSerial is start + i
            $pages[] = [
                'serial' => $startSerial + $i,
                'data' => $data,
            ];
        }

        // Handle HTML direct printing
        if ($request->input('action') === 'print') {
            return view($viewName, compact('pages', 'data'))->with('autoPrint', true);
        }

        // Handle sample PDF (first page only)
        if ($request->input('action') === 'sample') {
            $pages = [['serial' => $startSerial, 'data' => $data]];
        }

        // 100mm = 283.465 pt, 85mm = 240.945 pt
        $customPaper = array(0, 0, 283.465, 240.945);

        $pdf = Pdf::loadView($viewName, compact('pages', 'data'))
            ->setPaper($customPaper);

        $safeModel = str_replace(['/', '\\'], '-', ($data->MODEL ?? 'print'));
        return $pdf->stream('shipping_mark_' . $safeModel . '.pdf');
    }
}
