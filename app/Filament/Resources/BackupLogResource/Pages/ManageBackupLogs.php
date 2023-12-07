<?php

namespace App\Filament\Resources\BackupLogResource\Pages;

use App\Filament\Resources\BackupLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBackupLogs extends ManageRecords
{
    protected static string $resource = BackupLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
