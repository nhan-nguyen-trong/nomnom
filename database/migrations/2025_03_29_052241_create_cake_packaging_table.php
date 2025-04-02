<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCakePackagingTable extends Migration
{
    public function up(): void
    {
        Schema::create('cake_packaging', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cake_id')->constrained()->onDelete('cascade');
            $table->foreignId('packaging_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cake_packaging');
    }
}
