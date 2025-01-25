<?php

namespace ShopifyShipping\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopifyShippingCallbackController
{
    public function handle(Request $request)
    {
        Log::info('Shipping callback received', $request->all());

        return response()->json();
    }
}
