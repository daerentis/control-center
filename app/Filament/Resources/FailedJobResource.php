<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FailedJobResource\Pages;
use App\Filament\Resources\FailedJobResource\RelationManagers;
use App\Models\FailedJob;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FailedJobResource extends Resource
{
    protected static ?string $model = FailedJob::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Backup';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count() ?: null;
    }

    public static function getNavigationBadgeColor(): string | array | null
    {
        return 'danger';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('queue'),

                Textarea::make('exception')
                    ->columnSpanFull()
                    ->autosize()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('queue')
                    ->badge(),

                TextColumn::make('exception')
                    ->limit(120),

                TextColumn::make('failed_at')
            ])
            ->defaultSort('failed_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFailedJobs::route('/'),
        ];
    }
}
