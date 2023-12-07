<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class Invoice extends Model
{
    use Sushi;

    protected $fillable = [
        'is_paid',
    ];

    public function getRows()
    {
        // $responseInvoices = cache()->remember('invoices', 60 * 60, function () {
        //     $response = Http::withBasicAuth(env('FASTBILL_API_EMAIL'), env('FASTBILL_API_KEY'))->post(env('FASTBILL_API_URL'), [
        //         'SERVICE' => 'invoice.get',
        //         'LIMIT' => 90,
        //         'FILTER' => [
        //             'TYPE' => 'outgoing',
        //             'START_DUE_DATE' => now()->subMonth(6)->format('Y-m') . '-01'
        //         ],
        //     ]);

        //     return $response->json('RESPONSE.INVOICES');
        // });

        $response = Http::withBasicAuth(env('FASTBILL_API_EMAIL'), env('FASTBILL_API_KEY'))->post(env('FASTBILL_API_URL'), [
            'SERVICE' => 'invoice.get',
            'LIMIT' => 90,
            'FILTER' => [
                'TYPE' => 'outgoing',
                'START_DUE_DATE' => now()->subMonth(6)->format('Y-m') . '-01'
            ],
        ]);

        $responseInvoices = $response->json('RESPONSE.INVOICES');

        $invoices = collect($responseInvoices)->where('IS_CANCELED', '0')->map(function ($item) {
            return [
                'id' => $item['INVOICE_ID'],
                'number' => $item['INVOICE_NUMBER'],
                'title' => $item['INVOICE_TITLE'],
                'date' => $item['INVOICE_DATE'],
                'organization' => $item['ORGANIZATION'],
                'total' => $item['TOTAL'],
                'is_canceled' => $item['IS_CANCELED'],
                'is_paid' => (bool)$item['PAYMENT_INFO'],
                'document_url' => $item['DOCUMENT_URL'],
            ];
        });

        return array_values($invoices->toArray());
    }
}
