<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VersionResource\Pages;
use App\Models\Version;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Date;

class VersionResource extends Resource
{
    protected static ?string $model = Version::class;

    protected static ?string $navigationLabel = 'Versions';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Laravel';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('application')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('version')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVersions::route('/'),
        ];
    }
}
