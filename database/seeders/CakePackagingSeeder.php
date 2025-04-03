<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\Packaging;
use Illuminate\Database\Seeder;

class CakePackagingSeeder extends Seeder
{
    public function run(): void
    {
        $tiramisu = Cake::where('name', 'Tiramisu')->first();
        $pizza = Cake::where('name', 'Pizza')->first();
        $banhMi = Cake::where('name', 'Bánh mì')->first();

        $hopGiay = Packaging::where('name', 'Hộp giấy')->first();
        $tuiNilon = Packaging::where('name', 'Túi nilon')->first();

        // Tiramisu: Hộp giấy + Túi nilon
        $tiramisu->packagings()->attach($hopGiay->id, ['quantity' => 1]);
        $tiramisu->packagings()->attach($tuiNilon->id, ['quantity' => 1]);

        // Pizza: Hộp giấy
        $pizza->packagings()->attach($hopGiay->id, ['quantity' => 1]);

        // Bánh mì: Túi nilon
        $banhMi->packagings()->attach($tuiNilon->id, ['quantity' => 1]);
    }
}
