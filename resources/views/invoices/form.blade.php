@extends('layouts.app')
@section('title', $invoice->exists ? 'Edit Invoice' : 'Buat Invoice')
@section('breadcrumb', $invoice->exists ? 'Edit Invoice' : 'Buat Invoice')
@section('eyebrow', $invoice->exists ? $invoice->invoice_number : 'INVOICE BARU')
@section('description', 'Lengkapi informasi dan rincian tagihan dengan akurat.')
@section('actions')
    <a class="button button-secondary" href="{{ $invoice->exists ? route('invoices.show', $invoice) : route('invoices.index') }}"><x-icon name="back"/>Kembali</a>
@endsection
@section('content')
    <form action="{{ $invoice->exists ? route('invoices.update', $invoice) : route('invoices.store') }}" method="POST" data-invoice-form>
        @csrf
        @if($invoice->exists) @method('PUT') @endif
        <div class="form-layout">
            <div class="form-main">
                <section class="panel form-section">
                    <div class="form-section-title"><span class="step-number">01</span><div><h2>Informasi pihak terkait</h2><p>Identitas ini akan tercantum pada dokumen invoice.</p></div></div>
                    <div class="two-columns">
                        <div class="field-stack"><h3>Pengirim</h3><x-field name="sender_name" label="Nama perusahaan / pengirim" :value="$invoice->sender_name" :required="true" maxlength="255" placeholder="Contoh: Studio Aksara" autocomplete="organization"/><x-field name="sender_address" label="Alamat pengirim" :value="$invoice->sender_address" :textarea="true" :required="true" maxlength="2000" placeholder="Alamat lengkap perusahaan atau pengirim"/></div>
                        <div class="field-stack"><h3>Pelanggan</h3><x-field name="customer_name" label="Nama pelanggan" :value="$invoice->customer_name" :required="true" maxlength="255" placeholder="Nama pelanggan atau perusahaan"/><x-field name="customer_address" label="Alamat pelanggan" :value="$invoice->customer_address" :textarea="true" :required="true" maxlength="2000" placeholder="Alamat lengkap pelanggan"/></div>
                    </div>
                </section>
                <section class="panel form-section">
                    <div class="form-section-title"><span class="step-number">02</span><div><h2>Detail invoice</h2><p>Nomor invoice dibuat otomatis dan tidak berubah setelah disimpan.</p></div></div>
                    <div class="two-columns"><x-field name="invoice_date" label="Tanggal invoice" type="date" :value="$invoice->invoice_date?->format('Y-m-d') ?? today()->format('Y-m-d')" :required="true"/><x-field name="due_date" label="Jatuh tempo" type="date" :value="$invoice->due_date?->format('Y-m-d') ?? today()->addDays(14)->format('Y-m-d')" :required="true"/></div>
                </section>
                @include('invoices.partials.items')
                <section class="panel form-section">
                    <div class="form-section-title"><span class="step-number">04</span><div><h2>Catatan tambahan</h2><p>Tambahkan petunjuk pembayaran atau informasi lain bila diperlukan.</p></div></div>
                    <x-field name="notes" label="Catatan (opsional)" :value="$invoice->notes" :textarea="true" maxlength="5000" placeholder="Contoh: Pembayaran melalui transfer ke rekening perusahaan." rows="4"/>
                </section>
            </div>
            @include('invoices.partials.summary')
        </div>
    </form>
@endsection
