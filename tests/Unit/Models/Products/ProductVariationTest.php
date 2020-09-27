<?php

namespace Tests\Unit\Models\Products;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;

class ProductVariationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_one_variation_type()
    {
       $variation = factory(ProductVariation::class)->create();

       $this->assertInstanceOf(ProductVariationType::class, $variation->type);
    }

    public function test_it_belongs_to_product()
    {
       $variation = factory(ProductVariation::class)->create();
       $this->assertInstanceOf(Product::class, $variation->product);

    }

    public function test_it_returns_money_instance(){
      $variation = factory(ProductVariation::class)->create();

      $this->assertInstanceOf(Money::class,$variation->price);
  }

  public function test_returns_formatted_rpice(){
      $variation = factory(ProductVariation::class)->create([
          'price' => 1000
      ]);

      $this->assertEquals($variation->formattedPrice,'$10.00');
  }


  public function test_returns_productPriceIfPriceisNull(){
   $product = factory(Product::class)->create([
       'price' => 1000
   ]);

   $variation = factory(ProductVariation::class)->create([
      'price' => null,
      'product_id' => $product->id
  ]);

   $this->assertEquals($variation->price->amount(),$product->price->amount());
   }

   public function test_it_can_check_if_variation_is_differenttotheproduct(){
      $product = factory(Product::class)->create([
          'price' => 1000
      ]);
   
      $variation = factory(ProductVariation::class)->create([
         'price' => 2000,
         'product_id' => $product->id
     ]);
   
      $this->assertTrue($variation->priceVaries()) ;    
   }

   public function test_it_has_many_stocks(){
      $variation = factory(ProductVariation::class)->create();

      $variation->stocks()->save(
         factory(Stock::class)->make()
      );

      $this->assertInstanceOf(Stock::class,$variation->stocks->first());

   }

   public function test_it_has_stock_information(){
      $variation = factory(ProductVariation::class)->create();

      $variation->stocks()->save(
         factory(Stock::class)->make()
      );

      $this->assertInstanceOf(ProductVariation::class,$variation->stock->first());

   } 



   public function test_it_has_stock_count_pivot_within_stock_information(){
      $variation = factory(ProductVariation::class)->create();

      $variation->stocks()->save(
         factory(Stock::class)->make([
            'quantity' => $quantity = 10
         ])
      );

      $this->assertEquals($variation->stock->first()->pivot->stock,$quantity);

   } 


   public function test_if_in_stock(){
      $variation = factory(ProductVariation::class)->create();

      $variation->stocks()->save(
         factory(Stock::class)->make()
      );

      $this->assertEquals($variation->stock->first()->pivot->in_stock,1);

   }

   public function test_it_can_check_if_inStock(){
      $variation = factory(ProductVariation::class)->create();

      $variation->stocks()->save(
         factory(Stock::class)->make()
      );

      $this->assertTrue($variation->inStock());

   }

   public function test_it_can_get_stock_count(){
      $variation = factory(ProductVariation::class)->create();

      $variation->stocks()->save(
         factory(Stock::class)->make([

            'quantity' => $quantity = 10
         ])
    
        );

        $variation->stocks()->save(
         factory(Stock::class)->make([

            'quantity' => $quantity = 10
         ])
    
        );



      $this->assertEquals($variation->stockCount(), 20);

   }


}
