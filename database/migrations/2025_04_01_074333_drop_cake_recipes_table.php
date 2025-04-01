<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCakeRecipesTable extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('cake_recipes');
    }

    public function down(): void
    {
        Schema::create('cake_recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cake_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->timestamps();
        });
    }
}
