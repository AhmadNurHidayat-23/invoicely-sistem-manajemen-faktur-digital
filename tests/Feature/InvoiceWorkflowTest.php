<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Services\InvoiceWriter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InvoicePayload;
use Tests\TestCase;

class InvoiceWorkflowTest extends TestCase
{
    use RefreshDatabase, InvoicePayload;

    public function test_dashboard_and_invoice_pages_support_empty_database(): void
    {
        $this->get('/')->assertOk()->assertSee('Mulai dengan invoice pertama Anda');
        $this->get('/invoices')->assertOk()->assertSee('0 invoice ditemukan');
        $this->get('/invoices/create')->assertOk()->assertSee('Simpan Invoice');
        $this->get('/invoices/999')->assertNotFound()->assertSee('Halaman tidak ditemukan');
        $this->assertSame('sqlite', config('database.default'));
    }

    public function test_create_edit_status_and_delete_invoice_with_its_items(): void
    {
        $response = $this->post('/invoices', $this->payload());
        $invoice = Invoice::firstOrFail();
        $response->assertRedirect(route('invoices.show', $invoice))->assertSessionHas('success');
        $number = $invoice->invoice_number;
        $this->assertMatchesRegularExpression('/^INV-2026-\d{6}$/', $number);
        $this->assertSame(400000, $invoice->subtotal);
        $this->assertSame(44000, $invoice->tax_amount);
        $this->assertSame(444000, $invoice->total);
        $this->assertCount(2, $invoice->items);
        $this->assertSame($invoice->id, $invoice->items->first()->invoice->id);
        $this->get(route('invoices.show', $invoice))->assertOk()->assertSee('Cetak Invoice')->assertSee('Rp 444.000');
        $this->get(route('invoices.edit', $invoice))->assertOk()->assertSee('Pelanggan Nusantara');

        $changed = $this->payload([
            'customer_name' => 'Pelanggan Baru', 'tax_percentage' => '0',
            'items' => [['item_name' => 'Item pengganti', 'quantity' => 4, 'unit_price' => 10000]],
        ]);
        $this->put(route('invoices.update', $invoice), $changed)->assertRedirect(route('invoices.show', $invoice));
        $invoice->refresh();
        $this->assertSame($number, $invoice->invoice_number);
        $this->assertSame(40000, $invoice->total);
        $this->assertSame(0, $invoice->tax_amount);
        $this->assertCount(1, $invoice->items);
        $this->assertDatabaseMissing('invoice_items', ['item_name' => 'Konsultasi']);
        $this->assertDatabaseHas('invoices', ['sender_address' => 'Jl. Merdeka 1, Bandung']);
        $this->patch(route('invoices.status', $invoice), ['status' => 'paid'])->assertRedirect();
        $this->assertSame('paid', $invoice->fresh()->status);
        $this->delete(route('invoices.destroy', $invoice))->assertRedirect(route('invoices.index'));
        $this->assertDatabaseCount('invoices', 0);
        $this->assertDatabaseCount('invoice_items', 0);
    }

    public function test_numbers_are_unique_even_after_deletion_and_are_preserved_on_date_edit(): void
    {
        $writer = app(InvoiceWriter::class);
        $first = $writer->save($this->payload());
        $second = $writer->save($this->payload());
        $number = $second->invoice_number;
        $first->delete();
        $third = $writer->save($this->payload());
        $this->assertNotSame($number, $third->invoice_number);
        $this->put(route('invoices.update', $second), $this->payload([
            'invoice_date' => '2027-01-01', 'due_date' => '2027-01-15', 'invoice_number' => 'MANUAL',
        ]))->assertRedirect();
        $this->assertSame($number, $second->fresh()->invoice_number);
    }

    public function test_client_totals_are_ignored_and_tax_is_optional(): void
    {
        $this->post('/invoices', $this->payload([
            'subtotal' => 1, 'tax_amount' => 1, 'total' => 1, 'tax_percentage' => null,
        ]))->assertRedirect();
        $invoice = Invoice::firstOrFail();
        $this->assertSame(400000, $invoice->total);
        $this->assertSame(0, $invoice->tax_percentage);
    }

    public function test_failure_while_replacing_items_rolls_back_the_entire_update(): void
    {
        $writer = app(InvoiceWriter::class);
        $invoice = $writer->save($this->payload());
        InvoiceItem::creating(function () { throw new \RuntimeException('Simulasi kegagalan item'); });
        try {
            $writer->save($this->payload(['customer_name' => 'Tidak boleh tersimpan']), $invoice);
            $this->fail('Penyimpanan seharusnya gagal.');
        } catch (\RuntimeException $exception) {
            $this->assertSame('Simulasi kegagalan item', $exception->getMessage());
        } finally {
            InvoiceItem::flushEventListeners();
        }
        $this->assertSame('Pelanggan Nusantara', $invoice->fresh()->customer_name);
        $this->assertDatabaseCount('invoice_items', 2);
        $this->assertSame(444000, $invoice->fresh()->total);
    }
}
