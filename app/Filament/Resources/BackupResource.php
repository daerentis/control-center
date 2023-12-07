<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackupResource\Pages;
use App\Models\Backup;
use App\Models\Source;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BackupResource extends Resource
{
    protected static ?string $model = Backup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Backup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('status'),

                TextInput::make('source_id'),

                TextInput::make('disk_name'),

                TextInput::make('path'),

                TextInput::make('size_in_kb')
                    ->label('Size'),

                TextInput::make('real_size_in_kb')
                    ->label('Real Size'),

                Textarea::make('rsync_summary')
                    ->autosize()
                    ->columnSpanFull(),

                TextInput::make('rsync_time_in_seconds'),

                TextInput::make('rsync_current_transfer_speed'),

                TextInput::make('rsync_average_transfer_speed_in_MB_per_second'),

                TextInput::make('completed_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),

                TextColumn::make('source.name')
                    ->badge()
                    ->color('success'),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('size_in_kb')
                    ->label('Size'),

                TextColumn::make('real_size_in_kb')
                    ->label('Real Size'),

                TextColumn::make('completed_at')
                    ->since(),
            ])
            ->paginated([100, 200])
            ->defaultSort('created_at', 'desc')
            ->poll('5s')
            ->filters([
                SelectFilter::make('source_id')
                    ->label('Source')
                    ->options(Source::all()->pluck('name', 'id')),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->slideOver(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBackups::route('/'),
        ];
    }
}
