<?php

namespace Tests\Unit\Models\Categories;


use Tests\TestCase;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{

    public function test_it_many_children(){
        $category = factory(Category::class)->create();
       
       $borat = $category->children()->save(
            $category
        );
        
        $this->assertInstanceOf(Category::class, $category->children->first());
         
    }

  
    
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
