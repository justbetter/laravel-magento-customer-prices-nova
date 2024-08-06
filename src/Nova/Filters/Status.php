<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Status extends Filter
{
    /** @param Builder $query */
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return $query->where($value, '=', true);
    }

    public function options(NovaRequest $request): array
    {
        return [
            (string) __('To retrieve') => 'retrieve',
            (string) __('To update') => 'update',
        ];
    }
}
