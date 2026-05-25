<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class Container extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'containers';

    protected $fillable = [
        'thong_bao_xuat_hang_id',
        'chi_tiet_hang_hoa_id',
        'container_so',
        'kich_co',
        'so_luong',
        'tu',
        'den',
        'ghi_chu',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public function thongBaoXuatHang()
    {
        return $this->belongsTo(ThongBaoXuatHang::class, 'thong_bao_xuat_hang_id');
    }

    public function chiTietHangHoa()
    {
        return $this->belongsTo(ChiTietHangHoa::class, 'chi_tiet_hang_hoa_id');
    }
}
