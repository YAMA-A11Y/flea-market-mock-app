<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_search_items_by_partial_name_match()
    {
        Item::factory()->create(['name' => 'ノートパソコン', 'is_sold' => false]);
        Item::factory()->create(['name' => 'マウス', 'is_sold' => false]);

        $response = $this->get('/?tab=recommend&keyword=ノート');

        $response->assertStatus(200);
        $response->assertSee('ノートパソコン');
        $response->assertDontSee('マウス');
    }

    public function test_search_keyword_is_kept_when_switching_to_mylist_tab()
    {
        $user = User::factory()->create();
        $liked = Item::factory()->create(['name' => 'ノートパソコン', 'is_sold' => false]);
        Like::create([
            'user_id' => $user->id,
            'item_id' => $liked->id,
        ]);

        $resRecommend = $this->actingAs($user)->get('/?tab=recommend&keyword=ノート');
        $resRecommend->assertStatus(200);

        $resMylist = $this->actingAs($user)->get('/?tab=mylist&keyword=ノート');
        $resMylist->assertStatus(200);
        $resMylist->assertSee('ノートパソコン');
    }
}