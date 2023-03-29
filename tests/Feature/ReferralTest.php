<?php

namespace Tests\Feature;

use Database\Factories\ReferralFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ReferralTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_referral()
    {
        $user = UserFactory::new()->create();
        Auth::login($user);

        $response = $this->postJson(
            '/web/referral/create-referral',
            [
                'email' => fake()->safeEmail(),
            ]
        );
        $response->assertStatus(200);
    }

    public function test_referral_list()
    {
        $user = UserFactory::new()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'user_type' => 'ADMIN',
            'password' => Hash::make('admin123'),
        ]);
        Auth::login($user);

        $referrals = ReferralFactory::new()->count(10)->create();
        $response = $this->getJson('/web/referral/referral-list')->assertOk();
        $this->assertCount($referrals->count(), $response->json()['data']);
    }
}
