<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_liked_items_are_shown_on_mylist()
    {
        $user = User::factory()->create();

        $likedItem = Item::factory()->create(['name' => 'いいね商品', 'is_sold' => false]);
        $notlikedItem = Item::factory()->create(['name' => '未いいね商品', 'is_sold' => false]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいね商品');
        $response->assertDontSee('未いいね商品');
    }

    public function test_sold_liked_item_shows_sold_label_on_mylist()
    {
        $user = User::factory()->create();
        
        $soldLikedItem = Item::factory()->create([
            'name' => '売り切れいいね商品',
            'is_sold' => true,
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $soldLikedItem->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('売り切れいいね商品');
        $response->assertSee('SOLD');
    }

    public function test_guest_sees_nothing_on_mylist()
    {
        Item::factory()->create([
            'name' => '商品A',
            'is_sold' =>false
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertDontSee('商品A');
        $response->assertSee('商品がありません');
    }
}