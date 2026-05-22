<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thong_bao_xuat_hang_id')->constrained('thong_bao_xuat_hangs')->onDelete('cascade');
            $table->foreignId('chi_tiet_hang_hoa_id')->nullable()->constrained('chi_tiet_hang_hoas')->onDelete('no action');
            $table->string('container_so')->nullable();
            $table->string('kich_co')->nullable();
            $table->string('so_luong')->nullable();
            $table->string('tu')->nullable();
            $table->string('den')->nullable();
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
