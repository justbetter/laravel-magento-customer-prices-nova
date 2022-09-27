<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\RetrieveCustomerPriceJob;
use JustBetter\MagentoCustomerPrices\Models\MagentoCustomerPrice;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class Retry extends Action
{
    public $name = 'Retry';
    public $confirmText = 'Do you want to retry all failed jobs?';
    public $confirmButtonText = 'Retry';
    public $standalone = true;

    public function handle(ActionFields $fields, Collection $models): array
    {
        $skus = MagentoCustomerPrice::query()
            ->where('sync', '=', false)
            ->pluck('sku')
            ->toArray();

        MagentoCustomerPrice::query()
            ->where('sync', '=', false)
            ->update([
                'sync' => true,
                'fail_count' => 0
            ]);

        foreach ($skus as $sku) {
            RetrieveCustomerPriceJob::dispatch($sku, true);
        }

        return static::message(__('Retrying failed jobs...'));
    }
}
