<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Filters;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Failed extends Filter
{
    public function apply(NovaRequest $request, $query, $value): Builder
    {
        return match ($value) {
            'day' => $query->whereDate('last_failed', '>=', now()->startOfDay()),
            'week' => $query->whereDate('last_failed', '>=', now()->subWeek()->startOfDay()),
            'all' => $query->where('last_failed', '!=', null),
        };
    }

    public function options(NovaRequest $request): array
    {
        return [
            'Past day' => 'day',
            'Past week' => 'week',
            'All' => 'all',
        ];
    }
}
