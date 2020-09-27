<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_login_validation()
    {
      $this->json('POST','api/auth/login')
      ->assertJsonValidationErrors(['email']);
    }

    public function test_password_validation()
    {
      $this->json('POST','api/auth/login')
      ->assertJsonValidationErrors(['password']);
    }

    public function test_dummy()
    {
        $user = factory(User::class)->create();

      $this->json('POST','api/auth/login',
      ['email' => $user->email,
      'password' => 'nope'])
      ->assertJsonValidationErrors(['email']);
    }


    public function test_token_if_matched()
    {
        $user = factory(User::class)->create([
            'password' => 'cats'
        ]);

      $this->json('POST','api/auth/login',
      [
      'email' => $user->email,
      'password' => 'cats'
      ])
      ->assertJsonStructure([
          'meta' => [
              'token' 
          ]
          ]);
    }

    public function testitreturnsUsert_if_matched()
    {
        $user = factory(User::class)->create([
            'password' => 'cats'
        ]);

      $this->json('POST','api/auth/login',
      [
      'email' => $user->email,
      'password' => 'cats'
      ])
      ->assertJsonFragment([
         'email' => $user->email
          ]);
    }
}
