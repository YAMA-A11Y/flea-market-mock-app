<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    private function mypageSellUrl(): string
    {
        return '/mypage?page=sell';
    }

    private function mypageBuyUrl(): string
    {
        return '/mypage?page=buy';
    }

    public function test_mypage_shows_user_name()
    {
        $user = User::factory()->create([
            'name' => 'テスト太郎',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テスト太郎');
    }

    public function test_mypage_shows_sell_items_list()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の出品商品',
        ]);
        Item::factory()->create([
            'user_id' => $other->id,
            'name' => '他人の出品商品',
        ]);

        $response = $this->actingAs($user)->get($this->mypageSellUrl());

        $response->assertStatus(200);
        $response->assertSee('自分の出品商品');
        $response->assertDontSee('他人の出品商品');
    }

    public function test_mypage_shows_buy_items_list()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入した商品',
            'is_sold' => true,
        ]);        
        Order::create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'price' => $item->price,
        ]);

        $response = $this->actingAs($buyer)->get($this->mypageBuyUrl());

        $response->assertStatus(200);
        $response->assertSee('購入した商品');
    }

    public function test_mypage_shows_profile_image_when_set()
    {
        $user = User::factory()->create([
            'profile_image' => 'profiles/test.png',
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('storage/profiles/test.png');
    }
}