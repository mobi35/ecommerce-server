<?php

use App\Models\Category;


Route::resources(['categories' => 'Categories\CategoryController']);
Route::resources(['products' => 'Products\ProductController']);
Route::resources(['addresses' => 'Addresses\AddressController']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('register','Auth\RegisterController@action');
    Route::post('login','Auth\LoginController@action');
    Route::get('me','Auth\MeController@action');

});


Route::resource('cart','Cart\CartController',[
    'parameters' => [
        'cart' => 'productVariation'
    ]
]);