<?php

namespace App\Filament\Resources\SourceResource\Pages;

use App\Filament\Resources\SourceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSource extends ManageRecords
{
    protected static string $resource = SourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
