<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Services\InvoiceWriter;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(array_keys(Invoice::STATUSES))],
        ], [], ['q' => 'pencarian', 'status' => 'status pembayaran']);
        $query = Invoice::query();
        $search = $filters['q'] ?? '';

        if ($search !== '') {
            $query->where(fn ($q) => $q->where('invoice_number', 'like', '%'.$search.'%')
                ->orWhere('customer_name', 'like', '%'.$search.'%'));
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return view('invoices.index', [
            'invoices' => $query->latest('id')->paginate(10)->withQueryString(),
            'filters' => $filters,
        ]);
    }

    public function create(): View
    {
        return view('invoices.form', ['invoice' => new Invoice]);
    }

    public function store(InvoiceRequest $request, InvoiceWriter $writer): RedirectResponse
    {
        try {
            $invoice = $writer->save($request->validated());
        } catch (QueryException $exception) {
            report($exception);
            return back()->withInput()->with('error', 'Invoice belum dapat disimpan. Silakan coba kembali.');
        }

        return to_route('invoices.show', $invoice)->with('success', 'Invoice berhasil dibuat.');
    }

    public function show(Invoice $invoice): View
    {
        return view('invoices.show', ['invoice' => $invoice->load('items')]);
    }

    public function edit(Invoice $invoice): View
    {
        return view('invoices.form', ['invoice' => $invoice->load('items')]);
    }

    public function update(InvoiceRequest $request, Invoice $invoice, InvoiceWriter $writer): RedirectResponse
    {
        try {
            $writer->save($request->validated(), $invoice);
        } catch (QueryException $exception) {
            report($exception);
            return back()->withInput()->with('error', 'Perubahan belum dapat disimpan. Silakan coba kembali.');
        }

        return to_route('invoices.show', $invoice)->with('success', 'Invoice berhasil diperbarui.');
    }

    public function status(Request $request, Invoice $invoice): RedirectResponse
    {
        $data = $request->validate(['status' => ['required', Rule::in(array_keys(Invoice::STATUSES))]], [], ['status' => 'status pembayaran']);
        $invoice->update($data);

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        DB::transaction(fn () => $invoice->delete());

        return to_route('invoices.index')->with('success', 'Invoice beserta item berhasil dihapus.');
    }
}
