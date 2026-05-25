<?php

namespace App\Models;

use App\Enums\TypeNum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

class ChiTietHangHoa extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'chi_tiet_hang_hoas';

    protected $fillable = [
        'thong_bao_xuat_hang_id',
        'model',
        'size',
        'so_luong_tham_khao',
        'nw',
        'gw',
        'dai',
        'rong',
        'cao',
        'color',
        'selected_type_num',
        'extended_content',
        'using_print',
        'lot_no',
        'quantity',
        'created_by',
        'last_modified_by',
    ];

    protected $casts = [
        'selected_type_num' => TypeNum::class,
        'using_print' => 'boolean',
        'so_luong_tham_khao' => 'integer',
        'dai' => 'decimal:3',
        'rong' => 'decimal:3',
        'cao' => 'decimal:3',
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

    public function containers()
    {
        return $this->hasMany(Container::class, 'chi_tiet_hang_hoa_id');
    }
}
