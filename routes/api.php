<?php

use Illuminate\Routing\Route;
use ShopifyShipping\Http\Controllers\ShippingCallbackController;

Route::post('/shopify/shipping', [ShippingCallbackController::class, 'handle'])->name('shopify.shipping.callback');
