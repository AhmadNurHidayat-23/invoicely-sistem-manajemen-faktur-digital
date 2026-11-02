<?php

namespace Tests\Concerns;

trait InvoicePayload
{
    protected function payload(array $overrides = []): array
    {
        return array_replace([
            'sender_name' => 'Studio Pengirim', 'sender_address' => 'Jl. Merdeka 1, Bandung',
            'customer_name' => 'Pelanggan Nusantara', 'customer_address' => 'Jl. Mawar 2, Jakarta',
            'invoice_date' => '2026-11-02', 'due_date' => '2026-11-16',
            'tax_percentage' => '11', 'status' => 'unpaid', 'notes' => 'Terima kasih.',
            'items' => [
                ['item_name' => 'Desain antarmuka', 'quantity' => 2, 'unit_price' => 125000],
                ['item_name' => 'Konsultasi', 'quantity' => 3, 'unit_price' => 50000],
            ],
        ], $overrides);
    }
}
