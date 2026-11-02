<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Services\InvoiceWriter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Concerns\InvoicePayload;
use Tests\TestCase;

class InvoiceValidationTest extends TestCase
{
    use RefreshDatabase, InvoicePayload;

    public static function invalidInputs(): array
    {
        return [
            'pengirim kosong' => ['sender_name', '', 'sender_name'],
            'alamat pelanggan kosong' => ['customer_address', '', 'customer_address'],
            'tanggal tidak valid' => ['invoice_date', '2026-02-30', 'invoice_date'],
            'jatuh tempo mendahului invoice' => ['due_date', '2026-11-01', 'due_date'],
            'pajak negatif' => ['tax_percentage', '-1', 'tax_percentage'],
            'pajak melebihi batas' => ['tax_percentage', '100.01', 'tax_percentage'],
            'pajak terlalu presisi' => ['tax_percentage', '11.255', 'tax_percentage'],
            'pajak format eksponen' => ['tax_percentage', '1e1', 'tax_percentage'],
            'status sembarang' => ['status', 'deleted', 'status'],
            'tanpa item' => ['items', [], 'items'],
            'item bukan daftar' => ['items', 'rusak', 'items'],
            'nama item kosong' => ['items', [['item_name' => '', 'quantity' => 1, 'unit_price' => 100]], 'items.0.item_name'],
            'jumlah nol' => ['items', [['item_name' => 'A', 'quantity' => 0, 'unit_price' => 100]], 'items.0.quantity'],
            'jumlah pecahan' => ['items', [['item_name' => 'A', 'quantity' => '1.5', 'unit_price' => 100]], 'items.0.quantity'],
            'harga negatif' => ['items', [['item_name' => 'A', 'quantity' => 1, 'unit_price' => -1]], 'items.0.unit_price'],
            'harga terlalu besar' => ['items', [['item_name' => 'A', 'quantity' => 1, 'unit_price' => 1000000000]], 'items.0.unit_price'],
            'harga pecahan' => ['items', [['item_name' => 'A', 'quantity' => 1, 'unit_price' => '0.5']], 'items.0.unit_price'],
            'item berisi total palsu' => ['items', [['item_name' => 'A', 'quantity' => 1, 'unit_price' => 100, 'total_price' => 1]], 'items.0'],
        ];
    }

    #[DataProvider('invalidInputs')]
    public function test_invalid_invoice_is_rejected_without_database_changes(string $field, mixed $value, string $error): void
    {
        $this->from('/invoices/create')->post('/invoices', $this->payload([$field => $value]))
            ->assertRedirect('/invoices/create')->assertSessionHasErrors($error);
        $this->assertDatabaseCount('invoices', 0);
        $this->assertDatabaseCount('invoice_items', 0);

    }

    public function test_redirected_validation_summary_displays_errors_and_preserves_input(): void
    {
        $this->followingRedirects()->from('/invoices/create')->post('/invoices', $this->payload(['sender_name' => '']))
            ->assertOk()->assertSee('Periksa kembali isian Anda.')->assertSee('nama pengirim wajib diisi.')
            ->assertSee('Pelanggan Nusantara');
    }

    public function test_malformed_items_can_be_rendered_after_failed_validation(): void
    {
        $this->followingRedirects()->from('/invoices/create')->post('/invoices', $this->payload(['items' => 'rusak']))
            ->assertOk()->assertSee('Periksa kembali isian Anda.');
    }

    public function test_invalid_array_values_in_form_fields_do_not_break_the_error_page(): void
    {
        $this->followingRedirects()->from('/invoices/create')->post('/invoices', $this->payload([
            'sender_name' => ['invalid'],
            'items' => [['item_name' => ['invalid'], 'quantity' => ['invalid'], 'unit_price' => ['invalid']]],
        ]))->assertOk()->assertSee('Periksa kembali isian Anda.');
    }

    public function test_invalid_edit_does_not_modify_existing_invoice_or_items(): void
    {
        $invoice = app(InvoiceWriter::class)->save($this->payload());
        $this->put(route('invoices.update', $invoice), $this->payload(['items' => []]))->assertSessionHasErrors('items');
        $this->assertSame(444000, $invoice->fresh()->total);
        $this->assertDatabaseCount('invoice_items', 2);
    }

    public function test_it_rejects_more_than_100_items_and_invalid_status_changes(): void
    {
        $this->post('/invoices', $this->payload(['items' => array_fill(0, 101, ['item_name' => 'A', 'quantity' => 1, 'unit_price' => 1])]))->assertSessionHasErrors('items');
        $invoice = app(InvoiceWriter::class)->save($this->payload());
        $this->patch(route('invoices.status', $invoice), ['status' => 'admin'])->assertSessionHasErrors('status');
        $this->assertSame('unpaid', $invoice->fresh()->status);
    }

    public function test_validation_messages_and_escaped_output_use_the_expected_language_and_markup(): void
    {
        $this->post('/invoices', $this->payload(['sender_name' => '']))
            ->assertSessionHasErrors(['sender_name' => 'nama pengirim wajib diisi.']);
        $invoice = app(InvoiceWriter::class)->save($this->payload(['customer_name' => '<script>alert(1)</script>']));
        $this->get(route('invoices.show', $invoice))->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
    }
}
