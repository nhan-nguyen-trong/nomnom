<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cake_id')->constrained()->onDelete('cascade');
            $table->integer('ingredient_cost'); // Bỏ 10, 2
            $table->integer('packaging_cost'); // Bỏ 10, 2
            $table->integer('depreciation_cost'); // Bỏ 10, 2
            $table->integer('quantity_sold');
            $table->integer('total_cost'); // Bỏ 10, 2
            $table->integer('selling_price'); // Bỏ 10, 2
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
