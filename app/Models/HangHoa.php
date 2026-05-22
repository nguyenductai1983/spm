<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HangHoa extends Model
{
    use HasFactory;

    protected $table = 'hang_hoas';

    protected $fillable = [
        'code',
        'name',
    ];

    public function thongBaoXuatHangs()
    {
        return $this->hasMany(ThongBaoXuatHang::class, 'hang_hoa_id');
    }
}
