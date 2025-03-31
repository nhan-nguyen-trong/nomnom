<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Packaging;

class PackagingSeeder extends Seeder
{
    public function run(): void
    {
        Packaging::create([
            'name' => 'Túi giấy',
            'unit' => 'cái',
            'price' => 1.00, // 1,000 VND/cái
            'quantity' => 500,
        ]);

        Packaging::create([
            'name' => 'Hộp nhựa',
            'unit' => 'cái',
            'price' => 2.00, // 2,000 VND/cái
            'quantity' => 300,
        ]);
    }
}
