<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\RetrieveAllCustomerPricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class RetrieveAllCustomerPrices extends Action
{
    public $name = 'Retrieve all';
    public $confirmText = 'Do you want to retrieve all customer prices?';
    public $confirmButtonText = 'Retrieve';
    public $standalone = true;

    public function handle(ActionFields $fields, Collection $models): array
    {
        RetrieveAllCustomerPricesJob::dispatch($fields->force);

        return static::message(__('Retrieving customer prices...'));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            Boolean::make(__('Force update in Magento'), 'force')
        ];
    }
}
