<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesForProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images_for_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("image_name")->nullable();
            $table->boolean("cover");
            $table->integer('product_variation_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('product_variation_id')->references('id')->on('product_variations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images_for_product');
    }
}
