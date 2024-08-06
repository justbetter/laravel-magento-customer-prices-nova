<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\Retrieval\RetrieveCustomerPriceJob;
use JustBetter\MagentoCustomerPrices\Models\CustomerPrice;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class Retry extends Action
{
    public function __construct()
    {
        $this
            ->withName(__('Retry'))
            ->confirmText(__('Do you want to retry all failed jobs?'))
            ->confirmButtonText(__('Retry'))
            ->standalone();
    }

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        $skus = CustomerPrice::query()
            ->where('sync', '=', false)
            ->pluck('sku')
            ->toArray();

        CustomerPrice::query()
            ->where('sync', '=', false)
            ->update([
                'sync' => true,
                'fail_count' => 0,
            ]);

        foreach ($skus as $sku) {
            RetrieveCustomerPriceJob::dispatch($sku, true);
        }

        return ActionResponse::message(__('Retrying...'));
    }
}
