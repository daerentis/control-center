<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Closure;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Number;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->searchable(),

                TextColumn::make('organization')
                    ->searchable(),

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('date')
                    ->formatStateUsing(function ($state) {
                        return now()->parse($state)->isoFormat('ll');
                    }),

                TextColumn::make('total')
                    ->formatStateUsing(function ($state) {
                        return Number::currency($state, 'EUR', 'de');
                    }),

                TextColumn::make('is_paid')
                    ->label('Paid')
                    ->formatStateUsing(function ($state) {
                        return $state ? null : 'Mark as Paid';
                    })
                    ->color('primary')
                    ->icon('heroicon-s-currency-euro')
                    ->action(
                        Tables\Actions\Action::make('mark-as-paid')
                            ->icon('heroicon-s-currency-euro')
                            ->visible(function (Invoice $invoice) {
                                return !$invoice->is_paid;
                            })
                            ->requiresConfirmation()
                            ->action(function (Invoice $invoice) {
                                $response = Http::withBasicAuth(env('FASTBILL_API_EMAIL'), env('FASTBILL_API_KEY'))->post(env('FASTBILL_API_URL'), [
                                    'SERVICE' => 'invoice.setpaid',
                                    'DATA' => [
                                        'INVOICE_ID' => $invoice['id'],
                                        'PAID_DATE' => now()->format('Y-m-d'),
                                    ],
                                ]);

                                if ($response->status() == 200) {
                                    Notification::make()
                                        ->title('Invoice marked as paid')
                                        ->success()
                                        ->send();
                                }
                            }),
                    )
            ])
            ->defaultSort('number', 'desc')
            ->filters([
                SelectFilter::make('is_paid')
                    ->default(false)
                    ->options([
                        true => 'Paid',
                        false => 'Not Paid',
                    ]),
            ])
            ->headerActions([
                Action::make('show-open-times')
                    ->modalHeading('Open Times')
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->modalContent(function () {
                        $response = Http::withBasicAuth(env('FASTBILL_API_EMAIL'), env('FASTBILL_API_KEY'))->post(env('FASTBILL_API_URL'), [
                            'SERVICE' => 'time.get',
                            'LIMIT' => 100
                        ]);

                        $times = collect($response->json('RESPONSE.TIMES'));
                        $filtered_times = $times->filter(function ($value, $key) {
                            return !isset($value['INVOICE_ID']);
                        })->sortBy([['DATE', 'DESC']]);

                        return view('filament.open-times', ['times' => $filtered_times]);
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->color('default')
                    ->icon('heroicon-s-arrow-down-tray')
                    ->url(fn (Invoice $invoice) => $invoice['document_url'])
                    ->openUrlInNewTab(true)
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
        ];
    }
}
