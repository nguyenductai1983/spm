<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chi_tiets', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->nullable();
            $table->string('po_no')->nullable();
            $table->string('model')->nullable();
            $table->string('size')->nullable();
            $table->string('nw')->nullable();
            $table->string('gw')->nullable();
            $table->decimal('dai', 10, 3)->nullable();
            $table->decimal('rong', 10, 3)->nullable();
            $table->decimal('cao', 10, 3)->nullable();
            $table->string('color')->nullable();
            $table->string('type')->nullable();
            $table->integer('selected_type_num')->default(0); // 0: ROLLNO, 1: PACKAGENO, 2: BUNDLENO
            $table->string('type_suffix')->nullable();
            $table->boolean('using_print')->default(false);
            $table->string('start_serial')->nullable();
            $table->string('num_serial')->nullable();
            $table->string('lot_no')->nullable();
            $table->string('customer')->nullable();
            $table->string('quantity')->nullable();
            $table->string('commodity')->nullable();
            $table->string('customer_code')->nullable();
            
            $table->string('created_by')->nullable();
            $table->string('last_modified_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chi_tiets');
    }
};
