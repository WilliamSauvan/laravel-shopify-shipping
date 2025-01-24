<?php

namespace ShopifyShipping\Commands;

use Illuminate\Console\Command;
use ShopifyShipping\Services\ShopifyShippingService;

class ManageShippingCommand extends Command
{
    protected $signature = 'shopify:manage-shipping {action} {name?}';

    protected $description = 'Create or delete a Shopify shipping service';

    public function handle(ShopifyShippingService $shippingService)
    {
        $action = $this->argument('action');
        $name = $this->argument('name') ?? 'Default Shipping Service';

        if ($action === 'create') {
            $callbackUrl = route('shopify.shipping.callback');
            $response = $shippingService->createShippingService($name, $callbackUrl);
            $this->info('Shipping service created: ' . json_encode($response));
        } elseif ($action === 'delete') {
            $serviceId = $this->ask('Enter the service ID to delete');
            $shippingService->deleteShippingService($serviceId);
            $this->info('Shipping service deleted');
        } else {
            $this->error("Invalid action. Use 'create' or 'delete'.");
        }
    }
}
