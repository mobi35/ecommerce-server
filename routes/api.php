<?php

use App\Models\Category;




Route::resources(['stocks' => 'Stocks\StockController']);
Route::resources(['variations' => 'Products\ProductVariationController']);
Route::resources(['variationtype' => 'Products\ProductVariationTypeController']);
Route::resources(['categories' => 'Categories\CategoryController']);
Route::resources(['images' => 'Products\ImageController']);
Route::resources(['products' => 'Products\ProductController']);
Route::resources(['addresses' => 'Addresses\AddressController']);
Route::resources(['countries' => 'Countries\CountryController']);
Route::resources(['shipping' => 'Shipping\ShippingMethodController']);
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
Route::post('orders/prepare' , 'Orders\OrderController@prepare');
Route::post('orders/shipped' , 'Orders\OrderController@shipped');

Route::get('adminshow' , 'Orders\OrderController@adminshow');
Route::get('showvar','Products\ProductController@showVar');

Route::post('checkslug','Products\ProductController@checkSlug');
Route::get('random/{slug}','Products\ProductController@randomProducts');
Route::get('showAll','Products\ProductController@showAllWithoutPage');
Route::get('showAdmin','Products\ProductController@showAdminProducts');

Route::put('best/{id}','Products\ProductController@makeBest');

Route::post('sizeUpload','Products\ProductController@uploadSize');

Route::post('deleteVariation','Products\ProductController@deleteVariation');
Route::post('storeVariation','Products\ProductController@storeVariation');

//ADD SHIPPING IN COUNTRY
Route::post('addShippingInCountry','Countries\CountryController@addShippingInCountry');
Route::post('deleteCountryShipping','Shipping\ShippingMethodController@deleteCountryShipping');



Route::get('getCountryShipping/{id}','Shipping\ShippingMethodController@getCountryShipping');





Route::get('getVariations','Products\ProductVariationController@getVariations');


///DASHBOARDED

Route::get('users','Users\UserController@users');