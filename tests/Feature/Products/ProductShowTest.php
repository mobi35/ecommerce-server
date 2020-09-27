<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductShowTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testItFailsIfAProductCantBeFound()
    {
      $this->json('GET','api/products/nope')
       ->assertStatus(404);
    }

    public function testItShowsProduct()
    {
        $product = factory(Product::class)->create();

      $this->json('GET',"api/products/{$product->slug}")
       ->assertJsonFragment(['id' => $product->id]);
    }
}
