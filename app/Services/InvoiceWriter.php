<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceWriter
{
    public function __construct(private InvoiceCalculator $calculator) {}

    public function save(array $data, ?Invoice $invoice = null): Invoice
    {
        return DB::transaction(function () use ($data, $invoice) {
            $calculated = $this->calculator->calculate($data['items'], (string) ($data['tax_percentage'] ?? '0'));
            unset($data['items'], $data['tax_percentage']);
            $isNew = $invoice === null;
            $invoice ??= new Invoice;
            $invoice->fill(array_merge($data, $calculated['totals']));

            if ($isNew) {
                // Nomor sementara tidak pernah terlihat di luar transaksi.
                $invoice->invoice_number = 'PENDING-'.Str::ulid();
            }

            $invoice->save();

            if ($isNew) {
                $invoice->update(['invoice_number' => 'INV-'.$invoice->invoice_date->format('Y').'-'.str_pad((string) $invoice->id, 6, '0', STR_PAD_LEFT)]);
            }

            $invoice->items()->delete();
            $invoice->items()->createMany($calculated['items']);

            return $invoice;
        }, 3);
    }
}
