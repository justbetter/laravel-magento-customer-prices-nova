<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Sync extends Filter
{
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where('sync', '=', $value);
    }

    public function options(NovaRequest $request): array
    {
        return [
            'In sync' => 1,
            'Not in sync' => 0,
        ];
    }
}
