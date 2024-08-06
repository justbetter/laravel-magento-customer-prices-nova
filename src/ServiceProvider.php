<?php

namespace JustBetter\MagentoCustomerPricesNova;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\MagentoCustomerPricesNova\Nova\CustomerPriceResource;
use Laravel\Nova\Nova;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        Nova::serving(function (): void {
            Nova::resources([
                CustomerPriceResource::class,
            ]);
        });
    }
}
