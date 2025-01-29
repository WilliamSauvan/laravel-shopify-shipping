<?php

namespace ShopifyShipping\Contracts;

use App\Http\Requests\IncomingShopifyShippingRequest;
use Illuminate\Http\JsonResponse;

interface ShopifyShippingCallbackHandler
{
    public function handle(IncomingShopifyShippingRequest $request): JsonResponse;
}
