<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeIngredientSeeder extends Seeder
{
    public function run(): void
    {
        // Công thức bánh mì (recipe_id: 1)
        DB::table('recipe_ingredients')->insert([
            'recipe_id' => 1,
            'ingredient_id' => 1, // Bột mì
            'quantity' => 1.00, // 1kg bột mì cho 1 bánh mì
        ]);
        DB::table('recipe_ingredients')->insert([
            'recipe_id' => 1,
            'ingredient_id' => 2, // Sữa
            'quantity' => 10.00, // 10ml sữa cho 1 bánh mì
        ]);

        // Công thức bánh ngọt (recipe_id: 2)
        DB::table('recipe_ingredients')->insert([
            'recipe_id' => 2,
            'ingredient_id' => 1, // Bột mì
            'quantity' => 0.5, // 0.5kg bột mì cho 1 bánh ngọt
        ]);
        DB::table('recipe_ingredients')->insert([
            'recipe_id' => 2,
            'ingredient_id' => 2, // Sữa
            'quantity' => 20.00, // 20ml sữa cho 1 bánh ngọt
        ]);
    }
}
