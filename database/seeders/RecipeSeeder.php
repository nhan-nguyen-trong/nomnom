<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        Recipe::create(['name' => 'Bột gạo']);
        Recipe::create(['name' => 'Túi nilong']);
    }
}
