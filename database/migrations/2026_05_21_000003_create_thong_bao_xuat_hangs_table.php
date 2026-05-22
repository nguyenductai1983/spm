<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thong_bao_xuat_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('loai_hang')->nullable();
            $table->integer('so_luong')->default(0);
            $table->string('ref_no')->nullable();
            $table->string('po_no')->nullable();
            $table->date('ngay_du_kien')->nullable();
            $table->date('ngay_etd')->nullable();
            $table->text('ghi_chu')->nullable();
            
            $table->foreignId('khach_hang_id')->nullable()->constrained('khach_hangs')->onDelete('set null');
            $table->foreignId('hang_hoa_id')->nullable()->constrained('hang_hoas')->onDelete('set null');
            
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('no action');
            $table->foreignId('last_modified_by')->nullable()->constrained('users')->onDelete('no action');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('thong_bao_xuat_hangs');
    }
};
