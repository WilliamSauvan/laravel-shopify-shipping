<?php

namespace ShopifyShipping\Contracts;

use ShopifyShipping\Http\Requests\IncomingShopifyShippingRequest;
use Illuminate\Http\JsonResponse;

interface ShopifyShippingCallbackHandler
{
    public function handle(IncomingShopifyShippingRequest $request): JsonResponse;
}
