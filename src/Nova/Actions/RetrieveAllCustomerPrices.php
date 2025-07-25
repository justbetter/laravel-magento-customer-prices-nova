<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Actions;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use JustBetter\MagentoCustomerPrices\Jobs\Retrieval\RetrieveAllCustomerPricesJob;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Http\Requests\NovaRequest;

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
        /** @var ?string $from */
        $from = $fields->get('from');

        if ($from !== null) {
            $carbon = Carbon::parse($from);
        }

        /** @var bool $defer */
        $defer = $fields->get('defer');

        RetrieveAllCustomerPricesJob::dispatch($carbon ?? null, $defer);

        return ActionResponse::message(__('Retrieving...'));
    }

    public function fields(NovaRequest $request): array
    {
        return [
            DateTime::make(__('From'), 'from')
                ->help(__('Optional, retrieve updated prices from this date')),

            Boolean::make(__('Defer'), 'defer')
                ->default(true)
                ->help(__('When enabled, the prices will be marked for retrieval. Otherwise, all prices will be retrieved immediately.')),
        ];
    }
}
