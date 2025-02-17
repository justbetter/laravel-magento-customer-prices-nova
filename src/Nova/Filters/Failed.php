<?php

namespace JustBetter\MagentoCustomerPricesNova\Nova\Filters;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class Failed extends Filter
{
    /** @param  Builder  $query */
    public function apply(NovaRequest $request, EloquentBuilder $query, mixed $value): Builder|EloquentBuilder
    {
        return match ($value) {
            'day' => $query->whereDate('last_failed', '>=', now()->startOfDay()),
            'week' => $query->whereDate('last_failed', '>=', now()->subWeek()->startOfDay()),
            default => $query->where('last_failed', '!=', null),
        };
    }

    public function options(NovaRequest $request): array
    {
        return [
            (string) __('Past day') => 'day',
            (string) __('Past week') => 'week',
            (string) __('All') => 'all',
        ];
    }
}
