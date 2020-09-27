<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_user_not_authenticated()
    {
       $this->json('GET','api/auth/me')
       ->assertStatus(401);
    }

    public function test_if_returns_details()
    {
        //auth
        $user = factory(User::class)->create();
        $this->jsonAs($user,'GET','api/auth/me')
        ->assertJsonFragment([
            'email' => $user->email
        ]);
        //token


    }
}
