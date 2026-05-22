<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBaoXuatHang extends Model
{
    use HasFactory;

    protected $table = 'thong_bao_xuat_hangs';

    protected $fillable = [
        'loai_hang',
        'so_luong',
        'ref_no',
        'po_no',
        'ngay_du_kien',
        'ngay_etd',
        'ghi_chu',
        'khach_hang_id',
        'hang_hoa_id',
        'created_by',
        'last_modified_by',
    ];

    protected $casts = [
        'ngay_du_kien' => 'date',
        'ngay_etd' => 'date',
        'so_luong' => 'integer',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'khach_hang_id');
    }

    public function hangHoa()
    {
        return $this->belongsTo(HangHoa::class, 'hang_hoa_id');
    }

    public function chiTietHangHoas()
    {
        return $this->hasMany(ChiTietHangHoa::class, 'thong_bao_xuat_hang_id');
    }

    public function containers()
    {
        return $this->hasMany(Container::class, 'thong_bao_xuat_hang_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'last_modified_by');
    }
}
