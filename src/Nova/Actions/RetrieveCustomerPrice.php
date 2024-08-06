<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\Retrieval\RetrieveCustomerPriceJob;
use JustBetter\MagentoCustomerPrices\Models\CustomerPrice;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrieveCustomerPrice extends Action
{
    public function __construct()
    {
        $this
            ->withName(__('Retrieve'))
            ->confirmText(__('Do you want to retrieve the customer prices for the selected records?'))
            ->confirmButtonText(__('Retrieve'));
    }

    /** @param Collection<int, CustomerPrice> $models */
    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        /** @var bool $force */
        $force = $fields->get('force');

        foreach ($models as $model) {
            RetrieveCustomerPriceJob::dispatch($model->sku, $force);
        }

        return ActionResponse::message(__('Retrieving...'));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make(__('Force update in Magento'), 'force'),
        ];
    }
}
