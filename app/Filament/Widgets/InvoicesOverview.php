<?php

namespace App\Filament\Widgets;

use App\Models\FailedJob;
use App\Models\Invoice;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class InvoicesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Open invoices', Invoice::where('is_paid', false)->count()),
            Stat::make('Open amount', Number::currency(Invoice::where('is_paid', false)->sum('total'), 'EUR', 'de')),
        ];
    }
}
