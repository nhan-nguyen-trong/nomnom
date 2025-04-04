<?php

namespace Database\Seeders;

use App\Models\Packaging;
use Illuminate\Database\Seeder;

class PackagingSeeder extends Seeder
{
    public function run(): void
    {
        Packaging::create([
            'name' => 'Hộp giấy',
            'quantity' => 50,
            'unit' => 'cái',
            'price' => 2000,
            'unit_price' => 200,
        ]);
        Packaging::create([
            'name' => 'Túi nilon',
            'quantity' => 100,
            'unit' => 'cái',
            'price' => 500,
            'unit_price' => 200,
        ]);
    }
}
