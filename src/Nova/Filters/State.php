<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use JustBetter\MagentoCustomerPrices\Models\MagentoCustomerPrice;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class State extends Filter
{
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('state', $value);
    }

    public function options(NovaRequest $request): array
    {
        return [
            'Idle' => MagentoCustomerPrice::STATE_IDLE,
            'Retrieve' => MagentoCustomerPrice::STATE_RETRIEVE,
            'Retrieving' => MagentoCustomerPrice::STATE_RETRIEVING,
            'Update' => MagentoCustomerPrice::STATE_UPDATE,
            'Updating' => MagentoCustomerPrice::STATE_UPDATING,
            'Failed' => MagentoCustomerPrice::STATE_FAILED,
        ];
    }
}
