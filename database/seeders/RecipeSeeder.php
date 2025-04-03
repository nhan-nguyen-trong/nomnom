<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        Recipe::create(['name' => 'Công thức Tiramisu']);
        Recipe::create(['name' => 'Công thức Pizza']);
        Recipe::create(['name' => 'Công thức Bánh mì']);
    }
}
