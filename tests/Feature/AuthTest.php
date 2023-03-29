<?php

namespace Tests\Feature;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registration()
    {
        $response = $this->postJson(
            '/web/auth/register',
            [
                'name' => fake()->name(),
                'email' => fake()->safeEmail(),
                'password' => '123456',
                'password_confirmation' => '123456',
            ]
        );

        $response->assertStatus(200);
    }

    public function test_login()
    {
        $user = UserFactory::new()->create();

        $response = $this->postJson(
            '/web/auth/login',
            [
                'email' => $user->email,
                'password' => '123456',
            ]
        );

        $response->assertStatus(200);
    }
}
