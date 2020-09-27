<?php

namespace Tests\Feature\Categories;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_it_returns_collection_of_categories()
    {
        $categories = factory(Category::class, 2)->create();


 


       $response = $this->json('GET','api/categories');
        
       $categories->each(function ($category) use ($response) {

        $response->assertJsonFragment([
            'slug' => $category->slug
        ]
        );
      
        });
    
}


public function test_it_returnsOnlyParents()
    {
        $category = factory(Category::class)->create();
        $category->children()->save( 
            factory(Category::class)->create()
        );
        $this->json('GET','api/categories')
        ->assertJsonCount(1,'data');
    }

    public function test_returns_categories_ordered_by_given_order()
    {
        $category = factory(Category::class)->create([
            'order' => 2
        ]);

        $anothercategory = factory(Category::class)->create([
            'order' => 1
        ]);

        $this->json('GET','api/categories')
        ->assertSeeInOrder([
            $anothercategory->slug, $category->slug
        ]);
      
    }

    public function test_it_has_many_products(){
        $category = factory(Category::class)->create();

        $category->products()->save(
            factory(Product::class)->create()
        );

        $this->assertInstanceOf(Product::class, $category->products->first());
    }
}

