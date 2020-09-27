<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *@test
     * @return void
     */
    public function test_it_showsCollection()
    {
        $product = factory(Product::class)->create();

        $this->json('GET', 'api/products')
        ->assertJsonFragment([
            'id' => $product->id
        ]);
    }


    public function test_paginated()
    {

        $this->json('GET', 'api/products')
        ->assertJsonStructure([
            'meta'
        ]);
    }



}
