<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\Update\UpdateCustomerPriceJob;
use JustBetter\MagentoCustomerPrices\Models\CustomerPrice;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class UpdateCustomerPrice extends Action
{
    public function __construct()
    {
        $this
            ->withName(__('Update'))
            ->confirmText(__('Do you want to update the customer prices for the selected records?'))
            ->confirmButtonText(__('Update'));
    }

    /** @param Collection<int, CustomerPrice> $models */
    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        foreach ($models as $model) {
            UpdateCustomerPriceJob::dispatch($model);
        }

        return ActionResponse::message(__('Updating...'));
    }
}
