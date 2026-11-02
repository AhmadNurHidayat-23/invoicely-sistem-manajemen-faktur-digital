<?php

namespace App\Services;

class InvoiceCalculator
{
    /** Seluruh nilai uang dalam Rupiah bulat. Input harus sudah tervalidasi. */
    public function calculate(array $items, string $taxRate = '0'): array
    {
        [$whole, $fraction] = array_pad(explode('.', $taxRate), 2, '');
        $basisPoints = (int) $whole * 100 + (int) str_pad($fraction, 2, '0');
        $subtotal = 0;
        $lines = [];

        foreach ($items as $item) {
            $quantity = (int) $item['quantity'];
            $unitPrice = (int) $item['unit_price'];
            $lineTotal = $quantity * $unitPrice;
            $subtotal += $lineTotal;
            $lines[] = [
                'item_name' => $item['item_name'], 'quantity' => $quantity,
                'unit_price' => $unitPrice, 'total_price' => $lineTotal,
            ];
        }

        // Pembulatan half-up satu kali pada pajak, tanpa operasi floating-point.
        $taxAmount = intdiv($subtotal * $basisPoints + 5000, 10000);

        return [
            'items' => $lines,
            'totals' => [
                'tax_percentage' => $basisPoints, 'subtotal' => $subtotal,
                'tax_amount' => $taxAmount, 'total' => $subtotal + $taxAmount,
            ],
        ];
    }
}
