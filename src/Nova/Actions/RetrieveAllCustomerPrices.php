<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\Retrieval\RetrieveAllCustomerPricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;

class RetrieveAllCustomerPrices extends Action
{
    public function __construct()
    {
        $this
            ->withName(__('Retrieve all'))
            ->confirmText(__('Do you want to retrieve all customer prices?'))
            ->confirmButtonText(__('Retrieve'))
            ->standalone();
    }

    public function handle(ActionFields $fields, Collection $models): ActionResponse
    {
        RetrieveAllCustomerPricesJob::dispatch();

        return ActionResponse::message(__('Retrieving...'));
    }
}
