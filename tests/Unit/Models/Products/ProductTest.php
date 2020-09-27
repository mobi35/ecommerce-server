<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;

class ProductTest extends TestCase
{

    public function test_it_uses_the_slugs_for_the_route()
    {
       $product = new Product();
       $this->assertEquals($product->getRouteKeyName(), 'slug');
    }

    public function test_it_has_many_cat(){
        $product = factory(Product::class)->create();

        $product->categories()->save(
            factory(Category::class)->create()
        );

        $this->assertInstanceOf(Category::class, $product->categories->first());

    }

    public function test_has_variation(){
        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->create()
        );

        $this->assertInstanceOf(ProductVariation::class, $product->variations->first());

    }

    public function test_it_returns_money_instance(){
        $product = factory(Product::class)->create();

        $this->assertInstanceOf(Money::class,$product->price);
    }

    public function test_returns_formatted_rpice(){
        $product = factory(Product::class)->create([
            'price' => 1000
        ]);

        $this->assertEquals($product->formattedPrice,'$10.00');
    }

    public function test_checkIfItsInStock(){

        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->create()
        );

        $variation->stocks()->save(
            factory(Stock::class)->make()
        );

        $this->assertTrue($product->inStock());

    }

    public function test_can_getTheStockCount(){

        $product = factory(Product::class)->create();

        $product->variations()->save(
            $variation = factory(ProductVariation::class)->create()
        );

        $variation->stocks()->save(
            factory(Stock::class)->make([
                'quantity' => $quantity = 5
            ])
        );

        $this->assertEquals($product->stockCount(), $quantity);

    }
}
