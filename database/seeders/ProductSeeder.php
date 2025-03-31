<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Bán 5 bánh mì kẹp (cake_id: 1)
        Product::create([
            'cake_id' => 1,
            'ingredient_cost' => 102.50, // 5kg bột mì (5*20) + 50ml sữa (50*0.05)
            'packaging_cost' => 5.00, // 5 túi giấy (5*1)
            'depreciation_cost' => 0,
            'quantity_sold' => 5,
            'total_cost' => 107.50,
            'selling_price' => 150.00, // 30,000 VND/cái * 5
        ]);

        // Bán 3 bánh ngọt nhân kem (cake_id: 2)
        Product::create([
            'cake_id' => 2,
            'ingredient_cost' => 33.00, // 1.5kg bột mì (1.5*20) + 60ml sữa (60*0.05)
            'packaging_cost' => 6.00, // 3 hộp nhựa (3*2)
            'depreciation_cost' => 0,
            'quantity_sold' => 3,
            'total_cost' => 39.00,
            'selling_price' => 90.00, // 30,000 VND/cái * 3
        ]);
    }
}
