<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\UpdateCustomerPriceJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class UpdateCustomerPrice extends Action
{
    public $name = 'Update';
    public $confirmText = 'Do you want to update the customer prices for the selected records?';
    public $confirmButtonText = 'Update';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        foreach ($models as $model) {
            UpdateCustomerPriceJob::dispatch($model->sku);
        }

        return ActionResponse::message(__('Updating customer prices...'));
    }
}
