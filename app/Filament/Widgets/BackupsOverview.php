<?php

namespace App\Filament\Widgets;

use App\Models\FailedJob;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Artisan;
use Spatie\BackupServer\Models\Backup;

class BackupsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Backups', Backup::count()),
            Stat::make('Latest Backup', Backup::latest('completed_at')->first()->completed_at->diffForHumans()),
            Stat::make('Failed Jobs', FailedJob::count()),
        ];
    }
}
