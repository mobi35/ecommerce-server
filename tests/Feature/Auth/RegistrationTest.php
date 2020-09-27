<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_requires_a_name()
    {
      $this->json('POST','api/auth/register')
      ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_email()
    {
      $this->json('POST','api/auth/register',[
        
      ])
      ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_valid_email()
    {
      $this->json('POST','api/auth/register',[
          'email' => 'nope'
      ])
      ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_unique_email()
    {

        $user = factory(User::class)->create(
          
        );

      $this->json('POST','api/auth/register',[
          'email' => $user->email
      ])
      ->assertJsonValidationErrors(['email']);
    }

    public function test_it_requires_a_password()
    {
      $this->json('POST','api/auth/register',[
        
      ])
      ->assertJsonValidationErrors(['password']);
    }

    public function test_it_register_user()
    {
      $this->json('POST','api/auth/register',[
        'name' => $name ='mobi',
        'email' => $email = 'mobi35@gmail.com',
        'password' => 'secret'
      ]);

      $this->assertDatabaseHas('users',[
        'email' => $email,
        'name' => $name,

      ]);
     
    }


    public function test_it_returns_user_on_registration()
    {
      $this->json('POST','api/auth/register',[
        'name' => 'mobi',
        'email' => $email = 'mobi35@gmail.com',
        'password' => 'secret'
      ])->assertJsonFragment([
          'email' => $email
      ]);


     
    }
}
