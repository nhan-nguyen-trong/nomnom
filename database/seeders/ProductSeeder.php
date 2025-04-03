<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $tiramisu = Cake::where('name', 'Tiramisu')->first();
        $pizza = Cake::where('name', 'Pizza')->first();

        // Giao dịch bán 2 bánh Tiramisu
        Product::create([
            'cake_id' => $tiramisu->id,
            'ingredient_cost' => 4500, // 2 kg bột mì (1000đ/kg) + 1 kg đường (1500đ/kg) + 1 lít sữa (1500đ/kg) = 2000 + 1500 + 1500 = 5000đ/bánh
            'packaging_cost' => 5000, // Hộp giấy (2000đ) + Túi nilon (500đ) = 2500đ/bánh
            'depreciation_cost' => 20000, // 10000đ/bánh
            'quantity_sold' => 2,
            'total_cost' => 29500, // (5000 + 2500 + 10000) * 2
            'selling_price' => 40000,
        ]);

        // Giao dịch bán 1 bánh Pizza
        Product::create([
            'cake_id' => $pizza->id,
            'ingredient_cost' => 4250, // 1 kg bột mì (1000đ/kg) + 0.5 kg đường (1500đ/kg) + 2 quả trứng (2000đ/quả) = 1000 + 750 + 4000 = 5750đ/bánh
            'packaging_cost' => 2000, // Hộp giấy (2000đ)
            'depreciation_cost' => 8000, // 8000đ/bánh
            'quantity_sold' => 1,
            'total_cost' => 15750, // 5750 + 2000 + 8000
            'selling_price' => 20000,
        ]);
    }
}
