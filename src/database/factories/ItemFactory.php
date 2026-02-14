<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word(),
            'image_path' => 'items/dummy.png',
            'is_sold' => false,
            'brand' => null,
            'price' => 1000,
            'description' => 'テスト商品説明',
            'condition' => '良好',
        ];
    }
}