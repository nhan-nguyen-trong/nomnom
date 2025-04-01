<?php

namespace Database\Seeders;

use App\Models\Packaging;
use Illuminate\Database\Seeder;

class PackagingSeeder extends Seeder
{
    public function run(): void
    {
        Packaging::create([
            'name' => 'Bọc giấy',
            'quantity' => 100,
            'unit' => 'cái',
            'price' => 500, // Giá: 500 VNĐ/cái
        ]);

        Packaging::create([
            'name' => 'Túi nilong',
            'quantity' => 200,
            'unit' => 'cái',
            'price' => 200, // Giá: 200 VNĐ/cái
        ]);
    }
}
