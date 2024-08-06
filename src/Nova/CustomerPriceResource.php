<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova;

use Bolechen\NovaActivitylog\Resources\Activitylog;
use Illuminate\Http\Request;
use JustBetter\MagentoCustomerPrices\Models\CustomerPrice;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class CustomerPriceResource extends Resource
{
    public static string $model = CustomerPrice::class;

    public static $title = 'sku';

    public static $group = 'prices';

    public static $search = [
        'sku',
    ];

    public static function label(): string
    {
        return __('Customer prices');
    }

    public static function uriKey(): string
    {
        return 'magento-customer-prices';
    }

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

            Boolean::make(__('Retrieve'), 'retrieve')
                ->help(__('Automatically set to true if this customer price should be retrieved'))
                ->sortable(),

            Boolean::make(__('Update'), 'update')
                ->help(__('Automatically set to true if this customer price should be updated in Magento'))
                ->sortable(),

            DateTime::make(__('Last retrieved'), 'last_retrieved')
                ->readonly()
                ->sortable(),

            DateTime::make(__('Last updated'), 'last_updated')
                ->readonly()
                ->sortable(),

            DateTime::make(__('Last failed'), 'last_failed')
                ->readonly()
                ->sortable(),

            Number::make(__('Fail count'), 'fail_count')
                ->readonly()
                ->onlyOnDetail(),

            MorphMany::make(__('Activity'), 'activities', Activitylog::class),
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
            Filters\Product::make(),
            Filters\Status::make(),
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
