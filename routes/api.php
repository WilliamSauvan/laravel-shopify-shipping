<?php

use Illuminate\Support\Facades\Route;

Route::post(
    '/shopify/shipping',
    [config('laravel-shopify-shipping.callback_handler'), 'handle']
)->name('shopify.shipping.callback');
