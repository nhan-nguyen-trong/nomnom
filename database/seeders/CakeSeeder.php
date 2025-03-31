<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cake;

class CakeSeeder extends Seeder
{
    public function run(): void
    {
        Cake::create(['name' => 'Bánh mì kẹp']);
        Cake::create(['name' => 'Bánh ngọt nhân kem']);
    }
}
