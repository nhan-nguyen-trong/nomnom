<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        Ingredient::create([
            'name' => 'Bột mì',
            'unit' => 'kg',
            'price' => 20.00,
            'quantity' => 100.00,
        ]);

        Ingredient::create([
            'name' => 'Sữa',
            'unit' => 'ml',
            'price' => 0.05,
            'quantity' => 1000.00,
        ]);

        Ingredient::create([
            'name' => 'Đường',
            'unit' => 'kg',
            'price' => 15.00,
            'quantity' => 50.00,
        ]);
    }
}
