<?php

namespace Tests\Unit\Models\Users;

use App\Models\ProductVariation;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_hases_the_password_when_creating()
    {
       $user = factory(User::class)->create([

        'password' => 'cats'
        
       ]);


       $this->assertNotEquals($user->password,'cats');

    }


    public function test_has_cart_products()
    {
       $user = factory(User::class)->create();


       $user->cart()->attach(
           factory(ProductVariation::class)->create()
       );

       $this->assertInstanceOf(ProductVariation::class, $user->cart->first());
    }

    public function test_has_quantity_for_each_cart()
    {
       $user = factory(User::class)->create();


       $user->cart()->attach(
           factory(ProductVariation::class)->create(),[
               'quantity' => $quantity = 5
           ]
       );

       $this->assertEquals($user->cart->first()->pivot->quantity,$quantity);
    }


}
