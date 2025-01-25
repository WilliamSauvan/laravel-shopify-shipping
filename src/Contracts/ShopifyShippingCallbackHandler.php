<?php

namespace ShopifyShipping\Contracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ShopifyShippingCallbackHandler
{
    public function handle(Request $request): JsonResponse;
}
