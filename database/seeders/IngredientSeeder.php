<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientCategory;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy các phân loại
        $botMiCategory = IngredientCategory::where('name', 'Bột mì')->first();
        $duongCategory = IngredientCategory::where('name', 'Đường')->first();
        $suaCategory = IngredientCategory::where('name', 'Sữa')->first();
        $trungCategory = IngredientCategory::where('name', 'Trứng')->first();

        // Bột mì
        Ingredient::create([
            'category_id' => $botMiCategory->id,
            'name' => 'Bột mì A',
            'quantity' => 10,
            'unit' => 'kg',
            'price' => 20000, // Giá niêm yết
            'unit_price' => 1000, // Giá mỗi kg
        ]);
        Ingredient::create([
            'category_id' => $botMiCategory->id,
            'name' => 'Bột mì B',
            'quantity' => 15,
            'unit' => 'kg',
            'price' => 25000,
            'unit_price' => 1000,
        ]);

        // Đường
        Ingredient::create([
            'category_id' => $duongCategory->id,
            'name' => 'Đường trắng',
            'quantity' => 20,
            'unit' => 'kg',
            'price' => 30000,
            'unit_price' => 1500,
        ]);

        // Sữa
        Ingredient::create([
            'category_id' => $suaCategory->id,
            'name' => 'Sữa tươi',
            'quantity' => 30,
            'unit' => 'lít',
            'price' => 45000,
            'unit_price' => 1500,
        ]);

        // Trứng
        Ingredient::create([
            'category_id' => $trungCategory->id,
            'name' => 'Trứng gà',
            'quantity' => 50,
            'unit' => 'quả',
            'price' => 100000,
            'unit_price' => 2000,
        ]);
    }
}
