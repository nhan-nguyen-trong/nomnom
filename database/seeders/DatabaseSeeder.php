<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi các seeder theo thứ tự để đảm bảo dữ liệu liên kết đúng
        $this->call([
            IngredientSeeder::class,
            PackagingSeeder::class,
            RecipeSeeder::class,
            RecipeIngredientSeeder::class,
            CakeSeeder::class,
            CakeRecipeSeeder::class,
            CakePackagingSeeder::class,
            ProductSeeder::class,
        ]);

        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
