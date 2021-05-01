<?php

namespace Tests\Feature\Products;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    public function test_it_shows_a_collection_of_products()
    {
        $product = factory(Product::class)->create();

        $this->json('GET', 'api/products')
            ->assertJsonFragment([
                'id' => $product->id
            ]);
    }

    public function test_it_has_paginated_data()
    {
        $this->json('GET', 'api/products')
            ->assertJsonStructure([
                'meta'
            ]);
    }

    public function test_product_inserted(){

        $user = factory(User::class)->create([
            'password' => 'cats',
            'role' => 'admin'
        ]);
        
        $token = \JWTAuth::fromUser($user);
        
        $category = factory(Category::class)->create([
            'name' => 'berocha',
            'slug' => 'berocha'
        ]);

        $this->json('post','api/products?token='.$token ,[
            'name' => 'jakulot',
            'price' => 20,
            'description' => 'Jakulista',
            'slug' => 'gk',
            'category' => 'berocha'
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'jakulot',
            'slug' => 'gk'
        ]);


    }
}
