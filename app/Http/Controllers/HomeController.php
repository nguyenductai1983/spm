<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiTietHangHoa;
use App\Models\ThongBaoXuatHang;
use App\Models\KhachHang;
use App\Models\HangHoa;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'chi_tiets_count' => ChiTietHangHoa::count(),
            'thong_bao_count' => ThongBaoXuatHang::count(),
            'khach_hang_count' => KhachHang::count(),
            'hang_hoa_count' => HangHoa::count(),
        ];
        return view('home', compact('stats'));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }
}
