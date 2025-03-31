<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCakeRecipesTable extends Migration
{
    public function up(): void
    {
        Schema::create('cake_recipes', function (Blueprint $table) {
            $table->foreignId('cake_id')->constrained()->onDelete('cascade');
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->primary(['cake_id', 'recipe_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cake_recipes');
    }
}
