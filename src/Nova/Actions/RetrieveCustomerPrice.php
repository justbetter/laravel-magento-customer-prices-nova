<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\RetrieveCustomerPriceJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrieveCustomerPrice extends Action
{
    public $name = 'Retrieve';
    public $confirmText = 'Do you want to retrieve the customer prices for the selected records?';
    public $confirmButtonText = 'Retrieve';

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        foreach ($models as $model) {
            RetrieveCustomerPriceJob::dispatch($model->sku, $fields->force);
        }

        return ActionResponse::message(__('Retrieving customer prices...'));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make(__('Force update in Magento'), 'force')
        ];
    }
}
