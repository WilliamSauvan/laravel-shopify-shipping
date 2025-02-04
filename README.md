# Shopify Shipping Laravel Package

This package provides an integration with Shopify's REST API for managing custom shipping rates.

## Installation

1. Install via Composer:
   ```bash
   composer require wsauvan/shopify-shipping

2. Install delivery with the command:
   ```bash
   php artisan shopify:manage-shipping create {name}

3. Keep the generated ID for future deletion

4. Create your controller to handle incomming request, implementing `ShopifyShippingCallbackHandler`

Exemple : 
```php
<?php

namespace ShopifyShipping\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use ShopifyShipping\Contracts\ShopifyShippingCallbackHandler;
use ShopifyShipping\Http\Requests\IncomingShopifyShippingRequest;

class ShopifyShippingCallbackController implements ShopifyShippingCallbackHandler
{
    public function handle(IncomingShopifyShippingRequest $request): JsonResponse
    {
        Log::info('Shipping callback received', $request->all());

        return response()->json();
    }
}
```

You're good to go !
