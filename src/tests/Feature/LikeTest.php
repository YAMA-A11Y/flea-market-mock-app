<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_like_and_count_increases()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'いいね対策'
        ]);

        $res = $this->actingAs($user)->post('/item/' . $item->id . '/like');

        $this->assertTrue(in_array($res->getStatusCode(), [200, 302]), 'Unexpected status code: ' . $res->getStatusCode());
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $detail = $this->actingAs($user)->get('/item/' . $item->id);
        $detail->assertStatus(200);
        $detail->assertSee('js-like-count">1</span>', false);        
    }

    public function test_liked_item_shows_liked_state_on_icon()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'いいね対策'
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/item/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('data-liked="true"', false);
    }

    public function test_user_can_unlike_item_and_count_decreases()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'いいね対策'
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $res = $this->actingAs($user)->post('/item/' . $item->id . '/like');

        $this->assertTrue(in_array($res->getStatusCode(), [200, 302]), 'Unexpected status code: ' . $res->getStatusCode());
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $detail = $this->actingAs($user)->get('/item/' . $item->id);
        $detail->assertStatus(200);
        $detail->assertSee('js-like-count">0</span>', false);
    }
}