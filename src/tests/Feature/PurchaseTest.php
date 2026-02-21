<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    private function purchaseStoreUrl(Item $item): string
    {
        return route('items.purchase.store', ['item_id' => $item->id]);
    }

    private function itemsIndexUrl(): string
    {
        return route('items.index');
    }

    private function mypageBuyUrl(): string
    {
        return '/mypage?page=buy';
    }

    public function test_purchase_completes_and_order_is_created_and_item_becomes_sold()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'is_sold' => false,
        ]);
        $before = Order::count();

        $response = $this->actingAs($buyer)->post($this->purchaseStoreUrl($item), [
            'payment_method' => 'card'
        ]);

        $response->assertStatus(302);
        $this->assertSame($before + 1, Order::count());
        $this->assertDatabaseHas('orders', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);
        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'is_sold' => true,
        ]);
    }

    public function test_purchased_item_shown_as_sold_on_items_index()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'SOLD確認商品',
            'is_sold' => false,
        ]);

        $this->actingAs($buyer)->post($this->purchaseStoreUrl($item), [
            'payment_method' => 'card',
        ])->assertStatus(302);
        $index = $this->get($this->itemsIndexUrl());

        $index->assertStatus(200);
        $index->assertSee('SOLD');
        $index->assertSee('SOLD確認商品');
    }

    public function test_purchased_item_appears_in_mypage_buy_list()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入一覧に出る商品',
            'is_sold' => false,
        ]);

        $this->actingAs($buyer)->post($this->purchaseStoreUrl($item), [
            'payment_method' => 'card',
        ])->assertStatus(302);
        $page = $this->actingAs($buyer)->get($this->mypageBuyUrl());

        $page->assertStatus(200);
        $page->assertSee('購入一覧に出る商品');
    }

    public function test_purchase_page_shows_payment_method_select()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'is_sold' => false,
        ]);

        $response = $this->actingAs($buyer)->get(route('items.purchase', ['item_id' => $item->id]));

        $response->assertStatus(200);
        $response->assertSee('id="payment-method"', false);
        $response->assertSee('name="payment_method"', false);
        $response->assertSee('選択してください');
        $response->assertSee('コンビニ払い');
        $response->assertSee('カード支払い');
    }

    public function test_updated_address_is_reflected_on_purchase_page()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'is_sold' => false,
        ]);

        $response = $this->actingAs($buyer)->patch(
            route('purchase.address.update', ['item_id' => $item->id]),
            [
                'postcode' => '999-9999',
                'address' => '北海道札幌市1-1-1',
                'building' => 'テストビル202',
            ]
        );

        $response->assertStatus(302);

        $response = $this->actingAs($buyer)->get(
            route('items.purchase', ['item_id' => $item->id])
        );

        $response->assertStatus(200);
        $response->assertSee('999-9999');
        $response->assertSee('北海道札幌市1-1-1');
        $response->assertSee('テストビル202');
    }

    public function test_update_address_is_saved_when_purchasing()
    {
        $buyer = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'is_sold' => false,
        ]);
        $this->actingAs($buyer);
        
        $response = $this->patch(
            route('purchase.address.update', ['item_id' => $item->id]),
            [
                'postcode' => '888-8888',
                'address' => '東京都渋谷区2-2-2',
                'building' => 'テストマンション303',
            ]
        );
        
        $response->assertStatus(302);

        $response = $this->post(
            route('items.purchase.store', ['item_id' => $item->id]),
            ['payment_method' => 'card']
        );

        $response->assertStatus(302);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'shipping_postcode' => '888-8888',
            'shipping_address' => '東京都渋谷区2-2-2',
            'shipping_building' => 'テストマンション303',
        ]);
    }
}