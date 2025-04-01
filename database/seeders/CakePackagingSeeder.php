<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CakePackagingSeeder extends Seeder
{
    public function run(): void
    {
        // Bánh mì kẹp (cake_id: 1) dùng túi giấy (packaging_id: 1)
        DB::table('cake_packaging')->insert([
            'cake_id' => 1,
            'packaging_id' => 1,
            'quantity' => 10, // 10 bánh mì kẹp cần 10 túi giấy
        ]);

        // Bánh ngọt nhân kem (cake_id: 2) dùng hộp nhựa (packaging_id: 2)
        DB::table('cake_packaging')->insert([
            'cake_id' => 2,
            'packaging_id' => 2,
            'quantity' => 5, // 5 bánh ngọt cần 5 hộp nhựa
        ]);
    }
}
