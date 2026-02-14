<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_see_all_items_on_index()
    {
        $itemA = Item::factory()->create(['name' => '商品A', 'is_sold' => false]);
        $itemB = Item::factory()->create(['name' => '商品B', 'is_sold' => false]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('商品A');
        $response->assertSee('商品B');
    }

    public function test_sold_item_shows_sold_label_on_index()
    {
        $sold = Item::factory()->create([
            'name' => '売り切れ商品',
            'is_sold' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('売り切れ商品');
        $response->assertSee('SOLD');
    }

    public function test_logged_in_user_cannot_see_own_items_on_index()
    {
        $me = User::factory()->create();

        Item::factory()->create([
            'user_id' => $me->id,
            'name' => '自分の商品',
            'is_sold' => false,
        ]);

        Item::factory()->create([
            'name' => '他人の商品',
            'is_sold' => false,
        ]);

        $response = $this->actingAs($me)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他人の商品');
    }
}