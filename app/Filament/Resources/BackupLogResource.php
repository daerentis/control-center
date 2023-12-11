<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BackupLogResource\Pages;
use App\Models\BackupLog;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BackupLogResource extends Resource
{
    protected static ?string $model = BackupLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Logs';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Backup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('source.name'),

                TextInput::make('backup_id'),

                TextInput::make('task'),

                TextInput::make('level'),

                Textarea::make('message')
                    ->autosize()
                    ->columnSpanFull(),

                TextInput::make('created_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source.name')
                    ->badge()
                    ->color('success'),

                TextColumn::make('backup_id')
                    ->label('Backup'),

                TextColumn::make('task')
                    ->badge(),

                TextColumn::make('level'),

                TextColumn::make('message')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('created_at')
                    ->sortable(),
            ])
            ->paginated([100, 200])
            ->defaultSort('created_at', 'desc')
            ->poll('5s')
            ->filters([
                SelectFilter::make('source')
                    ->relationship('source', 'name'),

                SelectFilter::make('backup_id')
                    ->label('Backup')
                    ->relationship('backup', 'created_at', fn (Builder $query) => $query->latest()),

                SelectFilter::make('task')
                    ->options([
                        'backup' => 'Backup',
                        'cleanup' => 'Cleanup',
                    ]),

            ], layout: FiltersLayout::AboveContent)
            ->persistFiltersInSession()
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageBackupLogs::route('/'),
        ];
    }
}
