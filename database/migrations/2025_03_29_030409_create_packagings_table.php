<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packagings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('unit');
            $table->integer('price'); // Thay đổi từ decimal(8,2) thành integer
            $table->integer('quantity'); // Thay đổi từ decimal(8,2) thành integer
            $table->integer('unit_price')->default(0.00);
            $table->timestamps();
            $table->softDeletes(); // Thêm cột deleted_at để hỗ trợ xóa mềm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packagings');
    }
};
