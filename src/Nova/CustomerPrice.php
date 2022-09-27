<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova;

use Illuminate\Http\Request;
use Bolechen\NovaActivitylog\Resources\Activitylog;
use JustBetter\MagentoCustomerPrices\Models\MagentoCustomerPrice;
use JustBetter\NovaErrorLogger\Nova\Error;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class CustomerPrice extends Resource
{
    public static $model = MagentoCustomerPrice::class;

    public static $title = 'sku';

    public static $group = 'prices';

    public static $search = [
        'sku',
    ];

    public function fields(NovaRequest $request): array
    {
        return [
            Text::make(__('SKU'), 'sku')
                ->showOnPreview(),

            Boolean::make(__('Sync'), 'sync')
                ->showOnPreview(),

            Code::make(__('Prices'), 'prices')
                ->json()
                ->readonly()
                ->showOnPreview(),

            Badge::make(__('State'), 'state')
                ->map([
                    MagentoCustomerPrice::STATE_IDLE => 'info',
                    MagentoCustomerPrice::STATE_RETRIEVE => 'success',
                    MagentoCustomerPrice::STATE_RETRIEVING => 'warning',
                    MagentoCustomerPrice::STATE_UPDATE => 'success',
                    MagentoCustomerPrice::STATE_UPDATING => 'warning',
                    MagentoCustomerPrice::STATE_FAILED => 'danger',
                ])->showOnPreview(),

            DateTime::make(__('Last retrieved'), 'last_retrieved')
                ->readonly()
                ->sortable(),

            DateTime::make(__('Last updated'), 'last_updated')
                ->readonly()
                ->sortable(),

            DateTime::make(__('Last failed'), 'last_failed')
                ->readonly()
                ->help(__('Max allowed failures: ' . config('magento-customer-prices.fail_count')))
                ->sortable(),

            Number::make(__('Fail count'), 'fail_count')
                ->readonly()
                ->onlyOnDetail(),

            MorphMany::make(__('Activity'), 'activities', Activitylog::class),

            MorphMany::make(__('Errors'), 'errors', Error::class),
        ];
    }

    public function actions(NovaRequest $request): array
    {
        return [
            Actions\RetrieveCustomerPrice::make(),
            Actions\UpdateCustomerPrice::make(),
            Actions\RetrieveAllCustomerPrices::make(),
            Actions\Retry::make(),
        ];
    }

    public function filters(NovaRequest $request): array
    {
        return [
            Filters\Failed::make(),
            Filters\State::make(),
            Filters\Sync::make(),
        ];
    }

    public static function authorizedToCreate(Request $request): bool
    {
        return false;
    }

    public function authorizedToReplicate(Request $request): bool
    {
        return false;
    }
}
