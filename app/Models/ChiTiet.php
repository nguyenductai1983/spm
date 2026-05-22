<?php

namespace App\Models;

use App\Enums\TypeNum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTiet extends Model
{
    use HasFactory;

    protected $table = 'chi_tiets';

    protected $fillable = [
        'ref_no',
        'po_no',
        'model',
        'size',
        'nw',
        'gw',
        'dai',
        'rong',
        'cao',
        'color',
        'type',
        'selected_type_num',
        'type_suffix',
        'using_print',
        'start_serial',
        'num_serial',
        'lot_no',
        'customer',
        'quantity',
        'commodity',
        'customer_code',
        'created_by',
        'last_modified_by',
    ];

    protected $casts = [
        'selected_type_num' => TypeNum::class,
        'using_print' => 'boolean',
        'dai' => 'decimal:3',
        'rong' => 'decimal:3',
        'cao' => 'decimal:3',
    ];
}
