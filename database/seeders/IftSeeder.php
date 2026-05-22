<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create customer and commodity
        $customer1 = \App\Models\KhachHang::where('code', 'AIC')->first() ?? \App\Models\KhachHang::create(['code' => 'AIC', 'name' => 'THOMPSON BLDG. MTLS.']);
        $commodity1 = \App\Models\HangHoa::where('code', 'AIC')->first() ?? \App\Models\HangHoa::create(['code' => 'AIC', 'name' => 'PE SCAFFOLD DEBRIS MESH WITH BRASS GROMMETS 185GSM']);
        
        $customer2 = \App\Models\KhachHang::where('code', 'IFS')->first() ?? \App\Models\KhachHang::create(['code' => 'IFS', 'name' => 'EMIS FRANCE']);
        $commodity2 = \App\Models\HangHoa::where('code', 'IFS')->first() ?? \App\Models\HangHoa::create(['code' => 'IFS', 'name' => 'PE MONOFILAMENT RASCHEL MESH']);

        // Insert first ThongBaoXuatHang
        $tb1 = \App\Models\ThongBaoXuatHang::create([
            'khach_hang_id' => $customer1->id,
            'hang_hoa_id' => $commodity1->id,
            'loai_hang' => 'Hàng xuất',
            'so_luong' => 2,
            'ref_no' => 'AIC-GLG-017',
            'po_no' => '202625-01',
            'ngay_du_kien' => now(),
            'ngay_etd' => now()->addDays(7)
        ]);

        $ct1 = \App\Models\ChiTietHangHoa::create([
            'thong_bao_xuat_hang_id' => $tb1->id,
            'model' => 'DEBMESHTARP1852050G-FR',
            'size' => '(20W x 50L)feet - (6.09 x 15.24)meters',
            'gw' => '35.31',
            'color' => 'DARK GREEN',
            'lot_no' => 'AIC0176226-DG',
            'quantity' => '(02PCS/ BUNDLE)',
            'using_print' => 1,
            'selected_type_num' => 1, // PACKAGE NO.
        ]);

        \App\Models\Container::create([
            'thong_bao_xuat_hang_id' => $tb1->id,
            'chi_tiet_hang_hoa_id' => $ct1->id,
            'container_so' => 'CONT-001',
            'kich_co' => '40HC',
            'so_luong' => '2',
            'tu' => '1',
            'den' => '2'
        ]);

        // Insert second ThongBaoXuatHang
        $tb2 = \App\Models\ThongBaoXuatHang::create([
            'khach_hang_id' => $customer2->id,
            'hang_hoa_id' => $commodity2->id,
            'loai_hang' => 'Hàng xuất',
            'so_luong' => 3,
            'ref_no' => '260306/IFS-015TG',
            'po_no' => 'IF/9163/004/5',
            'ngay_du_kien' => now(),
            'ngay_etd' => now()->addDays(7)
        ]);

        $ct2 = \App\Models\ChiTietHangHoa::create([
            'thong_bao_xuat_hang_id' => $tb2->id,
            'model' => 'SDM-451-S-2x100-WH',
            'size' => 'W2m x L100m',
            'gw' => '9.08',
            'color' => 'WHITE',
            'using_print' => 1,
            'selected_type_num' => 0, // ROLL NO.
        ]);

        \App\Models\Container::create([
            'thong_bao_xuat_hang_id' => $tb2->id,
            'chi_tiet_hang_hoa_id' => $ct2->id,
            'container_so' => 'CONT-002',
            'kich_co' => '20DC',
            'so_luong' => '3',
            'tu' => '1',
            'den' => '3'
        ]);
    }
}
