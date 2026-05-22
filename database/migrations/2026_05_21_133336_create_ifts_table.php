<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement("DROP VIEW IF EXISTS IFTs");
        } else {
            \Illuminate\Support\Facades\DB::statement("IF OBJECT_ID('IFTs', 'V') IS NOT NULL DROP VIEW IFTs");
        }

        \Illuminate\Support\Facades\DB::statement("
            CREATE VIEW IFTs AS 
            SELECT c.id AS ID, c.model AS MODEL, c.size AS SIZE, c.gw AS GW, c.color AS COLOR, c.lot_no AS LotNo, c.quantity AS QUANTITY, c.extended_content AS TypeSuffix, 
            CASE WHEN c.using_print = 1 THEN 1 ELSE 0 END AS usingPrint, 
            CASE c.selected_type_num WHEN 0 THEN 'ROLL NO.' WHEN 1 THEN 'PACKAGE NO.' WHEN 2 THEN 'BUNDLE NO.' ELSE 'UNKNOWN' END AS TypeText, 
            t.ref_no AS REFNO, t.po_no AS PoNo, k.name AS Customer, k.code AS CustomerCode, h.name AS COMMODITY, 
            ct.tu AS StartSerial, ct.so_luong AS NumSerial
            FROM containers AS ct 
            LEFT OUTER JOIN chi_tiet_hang_hoas AS c ON ct.chi_tiet_hang_hoa_id = c.id 
            LEFT OUTER JOIN thong_bao_xuat_hangs AS t ON c.thong_bao_xuat_hang_id = t.id 
            LEFT OUTER JOIN khach_hangs AS k ON t.khach_hang_id = k.id 
            LEFT OUTER JOIN hang_hoas AS h ON t.hang_hoa_id = h.id
        ");
    }

    public function down(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
            \Illuminate\Support\Facades\DB::statement("DROP VIEW IF EXISTS IFTs");
        } else {
            \Illuminate\Support\Facades\DB::statement("IF OBJECT_ID('IFTs', 'V') IS NOT NULL DROP VIEW IFTs");
        }
    }
};
