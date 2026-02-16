<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_detail_page_displays_all_required_information()
    {
        $seller = User::factory()->create(['name' => '出品者']);
        $commenter = User::factory()->create(['name' => 'コメント太郎']);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'テストノート',
            'brand' => 'テストブランド',
            'price' => 1234,
            'description' => 'これはテスト説明です',
            'condition' => '良好',
            'image_path' => 'items/dummy.png',
            'is_sold' => false,
        ]);

        $catA = Category::factory()->create(['name' => '家電']);
        $catB = Category::factory()->create(['name' => '本']);
        $item->categories()->attach([$catA->id, $catB->id]);

        Like::create([
            'user_id' => $commenter->id,
            'item_id' => $item->id,
        ]);

        Comment::create([
            'user_id' => $commenter->id,
            'item_id' => $item->id,
            'body' => 'テストコメントです',
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('storage/items/dummy.png');
        $response->assertSee('テストノート');
        $response->assertSee('テストブランド');
        $response->assertSee('¥1,234');
        $response->assertSee('これはテスト説明です');
        $response->assertSee('良好');
        $response->assertSee('家電');
        $response->assertSee('本');
        $response->assertSee('js-like-count">1</span>', false);
        $response->assertSee('コメント(1)');
        $response->assertSee('コメント太郎');
        $response->assertSee('テストコメントです');
    }

    public function test_item_detail_page_shows_multiple_categories()
    {
        $item = Item::factory()->create([
            'name' => 'カテゴリ付き商品',
            'brand' => null,
            'price' => 1000,
            'description' => '説明',
            'condition' => '良好',
        ]);

        $catA = Category::factory()->create(['name' => '家電']);
        $catB = Category::factory()->create(['name' => '本']);
        $item->categories()->attach([$catA->id, $catB->id]);

        $response = $this->get('/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('家電');
        $response->assertSee('本');
    }
}