<?php

Route::group([
    'middleware' => ['api', 'cors'],
], function ($router) {
    Route::resource('customers', 'api\CustomerController');
    Route::resource('orders', 'api\OrderController');
    Route::resource('products', 'api\ProductController');

    Route::resource('cart', 'api\CartController');
    Route::resource('pedidos', 'api\PedidosController');
   
});