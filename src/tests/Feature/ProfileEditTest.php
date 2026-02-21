<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_edit_page_shows_existing_user_information()
    {
        $user = User::factory()->create([
            'username' => '変更前ユーザー',
            'postcode' => '123-4567',
            'address' => '北海道札幌市1-1-1',
            'profile_image' => 'profiles/sample.png',
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('name="username"', false);
        $response->assertSee('value="変更前ユーザー"', false);
        $response->assertSee('name="postcode"', false);
        $response->assertSee('value="123-4567"', false);
        $response->assertSee('name="address"', false);
        $response->assertSee('value="北海道札幌市1-1-1"', false);
        $response->assertSee('storage/profiles/sample.png');
    }
}