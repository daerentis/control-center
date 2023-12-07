<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SourceResource\Pages;
use App\Models\Source;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SourceResource extends Resource
{
    protected static ?string $model = Source::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Backup';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),

                TextInput::make('healthy'),

                TextInput::make('host'),

                TextInput::make('cron_expression'),

                TextInput::make('pre_backup_commands'),

                TextInput::make('post_backup_commands'),

                TextInput::make('includes'),

                TextInput::make('excludes'),

                TextInput::make('keep_all_backups_for_days'),

                TextInput::make('keep_daily_backups_for_days'),

                TextInput::make('keep_weekly_backups_for_weeks'),

                TextInput::make('keep_monthly_backups_for_months'),

                TextInput::make('keep_yearly_backups_for_years'),

                TextInput::make('delete_oldest_backups_when_using_more_megabytes_than'),

                TextInput::make('healthy_maximum_backup_age_in_days'),

                TextInput::make('healthy_maximum_storage_in_mb'),

                TextInput::make('created_at'),

                TextInput::make('updated_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->badge()
                    ->color('success'),

                IconColumn::make('healthy')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-exclamation-circle'),

                TextColumn::make('last_backup_completed_at'),

                TextColumn::make('number_of_backups'),
            ])
            ->filters([
                //
            ])
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
            'index' => Pages\ManageSource::route('/'),
        ];
    }
}
