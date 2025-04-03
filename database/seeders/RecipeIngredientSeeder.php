<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeIngredientSeeder extends Seeder
{
    public function run(): void
    {
        $botMiA = Ingredient::where('name', 'Bột mì A')->first();
        $duong = Ingredient::where('name', 'Đường trắng')->first();
        $sua = Ingredient::where('name', 'Sữa tươi')->first();
        $trung = Ingredient::where('name', 'Trứng gà')->first();

        $tiramisuRecipe = Recipe::where('name', 'Công thức Tiramisu')->first();
        $pizzaRecipe = Recipe::where('name', 'Công thức Pizza')->first();
        $banhMiRecipe = Recipe::where('name', 'Công thức Bánh mì')->first();

        // Công thức Tiramisu: 2 kg bột mì, 1 kg đường, 1 lít sữa
        $tiramisuRecipe->ingredients()->attach($botMiA->id, ['quantity' => 2]);
        $tiramisuRecipe->ingredients()->attach($duong->id, ['quantity' => 1]);
        $tiramisuRecipe->ingredients()->attach($sua->id, ['quantity' => 1]);

        // Công thức Pizza: 1 kg bột mì, 0.5 kg đường, 2 quả trứng
        $pizzaRecipe->ingredients()->attach($botMiA->id, ['quantity' => 1]);
        $pizzaRecipe->ingredients()->attach($duong->id, ['quantity' => 0.5]);
        $pizzaRecipe->ingredients()->attach($trung->id, ['quantity' => 2]);

        // Công thức Bánh mì: 1.5 kg bột mì, 1 lít sữa
        $banhMiRecipe->ingredients()->attach($botMiA->id, ['quantity' => 1.5]);
        $banhMiRecipe->ingredients()->attach($sua->id, ['quantity' => 1]);
    }
}
