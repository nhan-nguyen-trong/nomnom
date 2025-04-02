<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\Packaging;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class CakeSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy công thức và bao bì đã tạo
        $recipe1 = Recipe::where('name', 'Bột gạo')->first();
        $recipe2 = Recipe::where('name', 'Túi nilong')->first();
        $packaging1 = Packaging::where('name', 'Bọc giấy')->first();
        $packaging2 = Packaging::where('name', 'Túi nilong')->first();

        // Tạo bánh 1
        $cake1 = Cake::create([
            'name' => 'Tiramisu',
            'recipe_id' => $recipe1->id,
            'depreciation' => 10000,
        ]);

        // Gắn bao bì cho bánh 1 (quantity mặc định là 1)
        $cake1->packagings()->attach([
            $packaging1->id,
            $packaging2->id,
        ]);

        // Tạo bánh 2
        $cake2 = Cake::create([
            'name' => 'Bánh mì',
            'recipe_id' => $recipe2->id,
            'depreciation' => 5000,
        ]);

        // Gắn bao bì cho bánh 2 (quantity mặc định là 1)
        $cake2->packagings()->attach([
            $packaging1->id,
        ]);
    }
}
