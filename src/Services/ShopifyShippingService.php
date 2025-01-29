<?php

namespace ShopifyShipping\Services;

use GuzzleHttp\Client;

class ShopifyShippingService
{
    private string $accessToken;

    private string $baseApiUrl;

    public function __construct()
    {
        $shopDomain = config('laravel-shopify-shipping.shop_domain');
        $this->accessToken = config('laravel-shopify-shipping.access_token');
        $this->baseApiUrl = "https://$shopDomain/admin/api/2025-01";
    }

    public function createShippingService(string $name, string $callbackUrl): array
    {
        $client = new Client();
        $response = $client->post("{$this->baseApiUrl}/carrier_services.json", [
            'headers' => [
                'X-Shopify-Access-Token' => $this->accessToken,
                'Content-Type'           => 'application/json',
            ],
            'json' => [
                'carrier_service' => [
                    'name'              => $name,
                    'callback_url'      => $callbackUrl,
                    'service_discovery' => true,
                    'active'            => true,
                ],
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function deleteShippingService(int $serviceId): void
    {
        $client = new Client();
        $client->delete("{$this->baseApiUrl}/carrier_services/$serviceId.json", [
            'headers' => [
                'X-Shopify-Access-Token' => $this->accessToken,
            ],
        ]);
    }
}
