<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiet_hang_hoas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('thong_bao_xuat_hang_id')->constrained('thong_bao_xuat_hangs')->onDelete('cascade');
            $table->string('model')->nullable();
            $table->string('size')->nullable();
            $table->integer('so_luong_tham_khao')->default(0);
            $table->string('nw')->nullable();
            $table->string('gw')->nullable();
            $table->decimal('dai', 10, 3)->nullable();
            $table->decimal('rong', 10, 3)->nullable();
            $table->decimal('cao', 10, 3)->nullable();
            $table->string('color')->nullable();
            $table->integer('selected_type_num')->default(0); // 0: ROLLNO, 1: PACKAGENO, 2: BUNDLENO
            $table->text('extended_content')->nullable();
            $table->boolean('using_print')->default(false);
            $table->string('lot_no')->nullable();
            $table->string('quantity')->nullable();
            
            // Storing IDs as string or integer to support standard system users
            $table->string('created_by')->nullable();
            $table->string('last_modified_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_hang_hoas');
    }
};
