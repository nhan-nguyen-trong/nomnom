<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class CakeSeeder extends Seeder
{
    public function run(): void
    {
        $tiramisuRecipe = Recipe::where('name', 'Công thức Tiramisu')->first();
        $pizzaRecipe = Recipe::where('name', 'Công thức Pizza')->first();
        $banhMiRecipe = Recipe::where('name', 'Công thức Bánh mì')->first();

        Cake::create([
            'name' => 'Tiramisu',
            'recipe_id' => $tiramisuRecipe->id,
            'depreciation' => 10000,
        ]);
        Cake::create([
            'name' => 'Pizza',
            'recipe_id' => $pizzaRecipe->id,
            'depreciation' => 8000,
        ]);
        Cake::create([
            'name' => 'Bánh mì',
            'recipe_id' => $banhMiRecipe->id,
            'depreciation' => 5000,
        ]);
    }
}
