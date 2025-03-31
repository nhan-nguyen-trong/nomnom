<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CakeRecipeSeeder extends Seeder
{
    public function run(): void
    {
        // Bánh mì kẹp (cake_id: 1) dùng công thức bánh mì (recipe_id: 1)
        DB::table('cake_recipes')->insert([
            'cake_id' => 1,
            'recipe_id' => 1,
            'quantity' => 10, // Sản xuất 10 bánh mì kẹp
        ]);

        // Bánh ngọt nhân kem (cake_id: 2) dùng công thức bánh ngọt (recipe_id: 2)
        DB::table('cake_recipes')->insert([
            'cake_id' => 2,
            'recipe_id' => 2,
            'quantity' => 5, // Sản xuất 5 bánh ngọt nhân kem
        ]);
    }
}
