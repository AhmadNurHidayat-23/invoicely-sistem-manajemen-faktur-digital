<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    public const STATUSES = ['draft' => 'Draft', 'unpaid' => 'Belum Lunas', 'paid' => 'Lunas'];

    protected $fillable = [
        'invoice_number', 'sender_name', 'sender_address', 'customer_name',
        'customer_address', 'invoice_date', 'due_date', 'tax_percentage',
        'subtotal', 'tax_amount', 'total', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'invoice_date' => 'date', 'due_date' => 'date',
            'tax_percentage' => 'integer', 'subtotal' => 'integer',
            'tax_amount' => 'integer', 'total' => 'integer',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function taxRate(): string
    {
        return intdiv($this->tax_percentage, 100).'.'.str_pad((string) ($this->tax_percentage % 100), 2, '0', STR_PAD_LEFT);
    }

    public function isOverdue(): bool
    {
        return $this->status === 'unpaid' && $this->due_date->lt(today());
    }
}
