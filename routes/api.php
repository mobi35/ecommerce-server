<?php

use App\Models\Category;


Route::resources(['categories' => 'Categories\CategoryController']);
Route::resources(['products' => 'Products\ProductController']);
Route::resources(['addresses' => 'Addresses\AddressController']);
Route::resources(['countries' => 'Countries\CountryController']);
Route::get('addresses/{address}/shipping','Addresses\AddressShippingController@action');
Route::resources(['orders' => 'Orders\OrderController']);
Route::resources(['payment-methods' => 'PaymentMethods\PaymentMethodController']);
Route::group(['prefix' => 'auth', ['middleware' => 'throttle:20,5']], function () {
    Route::post('register','Auth\RegisterController@action');
    Route::post('login','Auth\LoginController@action');
    Route::get('me','Auth\MeController@action');
    Route::post('logout','Auth\LogoutController@action');
    Route::get('login/{service}','Auth\SocialLoginController@redirect');
    Route::get('login/{service}/callback','Auth\SocialLoginController@callback');
});

Route::get('addresses/{address}/shipping','Addresses\AddressShippingController@action');
Route::resource('cart','Cart\CartController',[
    'parameters' => [
        'cart' => 'productVariation'
    ]
]);

Route::post('orders/uploadPayment' , 'Orders\OrderController@uploadPayment');
Route::post('orders/pay' , 'Orders\OrderController@pay');
Route::post('orders/cancel' , 'Orders\OrderController@cancel');


Route::get('adminshow' , 'Orders\OrderController@adminshow');
Route::get('showvar','Products\ProductController@showVar');

Route::post('checkslug','Products\ProductController@checkSlug');

Route::get('showAll','Products\ProductController@showAllWithoutPage');

Route::post('storeVariation','Products\ProductController@storeVariation');

Route::get('getVariations','Products\ProductController@getVariations');
