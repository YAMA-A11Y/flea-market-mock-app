<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 出品者A
        User::factory()->create([
            'name' => 'seller_a',
            'email' => 'seller_a@example.com',
            'password' => Hash::make('password'),
        ]);

        // 出品者B
        User::factory()->create([
            'name' => 'seller_b',
            'email' => 'seller_b@example.com',
            'password' => Hash::make('password'),
        ]);
        
        $this->call([
            ItemSeeder::class,
        ]);
    }
}
