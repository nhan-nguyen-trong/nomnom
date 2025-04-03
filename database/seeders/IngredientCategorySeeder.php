<?php

namespace Database\Seeders;

use App\Models\IngredientCategory;
use Illuminate\Database\Seeder;

class IngredientCategorySeeder extends Seeder
{
    public function run(): void
    {
        IngredientCategory::create(['name' => 'Bột mì']);
        IngredientCategory::create(['name' => 'Đường']);
        IngredientCategory::create(['name' => 'Sữa']);
        IngredientCategory::create(['name' => 'Trứng']);
    }
}
