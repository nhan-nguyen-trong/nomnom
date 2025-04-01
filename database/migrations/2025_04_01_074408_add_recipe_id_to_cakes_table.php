<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecipeIdToCakesTable extends Migration
{
    public function up(): void
    {
        Schema::table('cakes', function (Blueprint $table) {
            $table->foreignId('recipe_id')->constrained()->onDelete('cascade')->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('cakes', function (Blueprint $table) {
            $table->dropForeign(['recipe_id']);
            $table->dropColumn('recipe_id');
        });
    }
}
