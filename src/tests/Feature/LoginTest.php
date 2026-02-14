<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'email' => 'test@example.com',
            'password' => 'password123',
        ], $overrides);
    }

    public function test_email_is_required()
    {
        $response = $this->from('/login')->post('/login', $this->validPayload([
            'email' => '',
        ]));

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['email']);

        $this->assertSame('メールアドレスを入力してください', session('errors')->first('email'));
    }

    public function test_password_is_required()
    {
        $response = $this->from('/login')->post('/login', $this->validPayload([
            'password' => '',
        ]));

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors(['password']);

        $this->assertSame('パスワードを入力してください', session('errors')->first('password')); 
    }

    public function test_invalid_credentials_show_error_message()
    {
        $response = $this->from('/login')->post('/login', $this->validPayload([
            'email' => 'notfound@example.com',
            'password' => 'password123',
        ]));

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors();

        $errors = session('errors')->all();
        
        $this->assertContains('ログイン情報が登録されていません', $errors); 
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $plain = 'password123';

        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make($plain),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => $plain,
        ]);

        $response->assertStatus(302);
        $this->assertAuthenticated(); 
    }
}
