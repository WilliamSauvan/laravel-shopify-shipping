<?php

use ShopifyShipping\Http\Controllers\ShopifyShippingCallbackController;

return [
    'shop_domain'  => env('SHOPIFY_SHOP_DOMAIN'),
    'access_token' => env('SHOPIFY_ACCESS_TOKEN'),
    'callback_handler' => env('SHOPIFY_SHIPPING_HANDLER', ShopifyShippingCallbackController::class . '@handle'),
];
