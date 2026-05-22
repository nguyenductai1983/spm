<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;

    protected $table = 'khach_hangs';

    protected $fillable = [
        'code',
        'name',
    ];

    public function thongBaoXuatHangs()
    {
        return $this->hasMany(ThongBaoXuatHang::class, 'khach_hang_id');
    }
}
