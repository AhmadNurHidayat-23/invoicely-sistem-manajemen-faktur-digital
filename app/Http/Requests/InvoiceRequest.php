<?php

namespace App\Http\Requests;

use App\Models\Invoice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_address' => ['required', 'string', 'max:2000'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_address' => ['required', 'string', 'max:2000'],
            'invoice_date' => ['required', 'date_format:Y-m-d'],
            'due_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:invoice_date'],
            'status' => ['required', Rule::in(array_keys(Invoice::STATUSES))],
            'tax_percentage' => ['nullable', 'numeric', 'min:0', 'max:100', 'regex:/^\d{1,3}(\.\d{1,2})?$/'],
            'notes' => ['nullable', 'string', 'max:5000'],
            'items' => ['required', 'array', 'min:1', 'max:100'],
            'items.*' => ['required', 'array:item_name,quantity,unit_price'],
            'items.*.item_name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            'items.*.unit_price' => ['required', 'integer', 'min:0', 'max:999999999'],
        ];
    }

    public function attributes(): array
    {
        return [
            'sender_name' => 'nama pengirim', 'sender_address' => 'alamat pengirim',
            'customer_name' => 'nama pelanggan', 'customer_address' => 'alamat pelanggan',
            'invoice_date' => 'tanggal invoice', 'due_date' => 'tanggal jatuh tempo',
            'tax_percentage' => 'persentase pajak', 'status' => 'status pembayaran',
            'notes' => 'catatan', 'items' => 'item invoice', 'items.*' => 'item invoice',
            'items.*.item_name' => 'nama produk atau jasa',
            'items.*.quantity' => 'jumlah item', 'items.*.unit_price' => 'harga satuan',
        ];
    }
}
