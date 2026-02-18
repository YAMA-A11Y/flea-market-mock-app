<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private function commentUrl(Item $item): string
    {
        return route('items.comment', ['item_id' => $item->id]);
    }

    public function test_logged_in_user_can_post_comment_and_count_increases()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);
        $before = Comment::where('item_id', $item->id)->count();

        $response = $this->actingAs($user)->post($this->commentUrl($item),[
            'body' => 'テストコメントです',
        ]);

        $this->assertTrue(in_array($response->getStatusCode(), [200, 302]), 'Unexpect status code: ' . $response->getStatusCode());

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'body' => 'テストコメントです',
        ]);
        $after = Comment::where('item_id', $item->id)->count();
        $this->assertSame($before + 1, $after);
    }

    public function test_guest_cannot_post_comment()
    {
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);
        $before = Comment::where('item_id', $item->id)->count();

        $response = $this->post($this->commentUrl($item), [
            'body' => 'ログインしてないコメント',
        ]);

        $this->assertTrue(in_array($response->getStatusCode(), [302, 401, 403]),  'Unexpected status code: ' . $response->getStatusCode());
        if ($response->getStatusCode() === 302) {
            $response->assertRedirect('/login');
        }
        $after = Comment::where('item_id', $item->id)->count();
        $this->assertSame($before, $after);
    }

    public function test_comment_is_required_validation_error()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
        'user_id' => $seller->id,
        ]);
        $before = Comment::where('item_id', $item->id)->count();

        $response = $this->actingAs($user)
        ->from('/item/' . $item->id)
        ->post($this->commentUrl($item), [
            'body' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['body']);
        $after = Comment::where('item_id', $item->id)->count();
        $this->assertSame($before, $after);
    }

    public function test_comment_max_255_validation_error()
    {
        $user = User::factory()->create();
        $seller = User::factory()->create();
        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);
        $before = Comment::where('item_id', $item->id)->count();
        $tooLong = str_repeat('あ', 256);

        $response = $this->actingAs($user)
            ->from('/item/' . $item->id)
            ->post($this->commentUrl($item), [
                'body' => $tooLong,
            ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['body']);
        $after = Comment::where('item_id', $item->id)->count();
        $this->assertSame($before, $after);
    }
}