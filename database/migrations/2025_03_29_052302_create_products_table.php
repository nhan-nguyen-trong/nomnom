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
            $table->decimal('ingredient_cost'); // Bỏ 10, 2
            $table->decimal('packaging_cost'); // Bỏ 10, 2
            $table->decimal('depreciation_cost'); // Bỏ 10, 2
            $table->integer('quantity_sold');
            $table->decimal('total_cost'); // Bỏ 10, 2
            $table->decimal('selling_price'); // Bỏ 10, 2
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
