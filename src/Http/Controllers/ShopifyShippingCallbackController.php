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
