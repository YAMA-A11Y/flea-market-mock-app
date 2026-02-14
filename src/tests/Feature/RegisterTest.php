<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ], $overrides);
    }

    public function test_name_is_required()
    {
        $response = $this->from('/register')->post('/register', $this->validPayload([
            'name' => '',
        ]));

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['name']);

        $this->assertSame('お名前を入力してください', session('errors')->first('name'));
    }

    public function test_email_is_required()
    {
         $response = $this->from('/register')->post('/register', $this->validPayload([
            'email' => '',
        ]));

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['email']);

        $this->assertSame('メールアドレスを入力してください', session('errors')->first('email'));
    }

    public function test_password_required()
    {
        $response = $this->from('/register')->post('/register', $this->validPayload([
            'password' => '',
            'password_confirmation' => '',
        ]));

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password']);

        $this->assertSame('パスワードを入力してください', session('errors')->first('password'));
    }

    public function test_password_must_be_at_least_8_characters()
    {
        $response = $this->from('/register')->post('/register', $this->validPayload([
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]));

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password']);

        $this->assertSame('パスワードは8文字以上で入力してください', session('errors')->first('password'));
    }

    public function test_password_confirmation_must_match()
    {
        $response = $this->from('/register')->post('/register', $this->validPayload([
            'password' => 'password123',
            'password_confirmation' => 'password999',
        ]));

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors(['password_confirmation']);

        $this->assertSame('パスワードと一致しません', session('errors')->first('password_confirmation'));
    }

    public function test_user_can_register_and_is_redirected_to_profile_setup()
    {
        $payload = $this->validPayload([
            'email' => 'test_' . uniqid() . '@example.com',
        ]);

        $response = $this->post('/register', $payload);

        $response->assertRedirect('/mypage/profile');
        
        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
            'name' => $payload['name'],
        ]);
    }
}