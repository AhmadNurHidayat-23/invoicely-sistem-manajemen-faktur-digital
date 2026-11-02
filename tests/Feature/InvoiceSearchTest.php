<?php

namespace Tests\Feature;

use App\Models\Invoice;
use App\Services\InvoiceWriter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InvoicePayload;
use Tests\TestCase;

class InvoiceSearchTest extends TestCase
{
    use RefreshDatabase, InvoicePayload;

    public function test_dashboard_statistics_are_derived_from_all_database_records(): void
    {
        $writer = app(InvoiceWriter::class);
        foreach (['paid', 'unpaid', 'draft'] as $status) $writer->save($this->payload(['status' => $status]));
        $this->get('/')->assertOk()->assertViewHas('stats', fn ($stats) =>
            (int) $stats->total_count === 3 && (int) $stats->paid_count === 1 &&
            (int) $stats->unpaid_count === 1 && (int) $stats->total_value === 1332000
        );
    }

    public function test_search_and_status_filter_can_be_combined(): void
    {
        $writer = app(InvoiceWriter::class);
        $one = $writer->save($this->payload(['customer_name' => 'Aksara', 'status' => 'paid']));
        $two = $writer->save($this->payload(['customer_name' => 'Nusantara', 'status' => 'unpaid']));
        $this->get('/invoices?q=Aksara')->assertOk()->assertSee($one->invoice_number)->assertDontSee($two->invoice_number);
        $this->get('/invoices?q='.$two->invoice_number)->assertSee('Nusantara')->assertDontSee('Aksara');
        $this->get('/invoices?status=paid')->assertSee('Aksara')->assertDontSee('Nusantara');
        $this->get('/invoices?q=Nusantara&status=paid')->assertSee('Invoice tidak ditemukan');
        $this->get('/invoices?status=invalid')->assertSessionHasErrors('status');
    }

    public function test_pagination_retains_search_and_status(): void
    {
        $writer = app(InvoiceWriter::class);
        for ($i = 0; $i < 12; $i++) $writer->save($this->payload(['status' => 'paid']));
        $this->get('/invoices?q=Pelanggan&status=paid')->assertOk()
            ->assertSee('Menampilkan 1–10 dari 12 invoice')
            ->assertSee('q=Pelanggan&amp;status=paid&amp;page=2', false);
        $this->get('/invoices?q=Pelanggan&status=paid&page=2')->assertSee('Menampilkan 11–12 dari 12 invoice');
        $this->assertSame(12, Invoice::count());
    }
}
