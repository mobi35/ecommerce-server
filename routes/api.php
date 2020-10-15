<?php

use App\Models\Category;


Route::resources(['categories' => 'Categories\CategoryController']);
Route::resources(['products' => 'Products\ProductController']);
Route::resources(['addresses' => 'Addresses\AddressController']);
Route::resources(['countries' => 'Countries\CountryController']);
Route::get('addresses/{address}/shipping','Addresses\AddressShippingController@action');
Route::resources(['orders' => 'Orders\OrderController']);

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