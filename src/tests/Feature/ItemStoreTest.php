<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_item_with_required_fields_and_categories()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $categoryA = Category::forcecreate(['name' => 'カテゴリA']);
        $categoryB = Category::forcecreate(['name' => 'カテゴリB']);

        $response = $this->actingAs($user)->post(
            route('items.sell.store'),
            [
                'name' => 'テスト商品',
                'brand' => 'テストブランド',
                'description' => 'これはテスト商品です',
                'condition' => '良好',
                'price' => 1234,
                'categories' => ['カテゴリA', 'カテゴリB'],
                'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
            ]
        );

        $response->assertStatus(302);

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'これはテスト商品です',
            'condition' => '良好',
            'price' => 1234,
            'is_sold' => 0,
        ]);

        $item = Item::where('user_id', $user->id)
            ->where('name', 'テスト商品')
            ->firstOrFail();

        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $categoryA->id,
        ]);
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $categoryB->id,
        ]);

        Storage::disk('public')->assertExists($item->image_path);
    }
}