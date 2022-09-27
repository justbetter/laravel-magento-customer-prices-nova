<?php

namespace JustBetter\MagentoCustomerPricesNova;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\MagentoCustomerPricesNova\Nova\CustomerPrice;
use Laravel\Nova\Nova;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        Nova::resources([
            CustomerPrice::class,
        ]);
    }
}
