@extends('layouts.app')
@section('title', 'Detail Invoice')
@section('breadcrumb', $invoice->invoice_number)
@section('eyebrow', 'DOKUMEN TAGIHAN')
@section('description', 'Tinjau rincian invoice dan kelola status pembayaran.')
@section('actions')
    <a class="button button-secondary" href="{{ route('invoices.index') }}"><x-icon name="back"/>Kembali</a>
    <a class="button button-secondary" href="{{ route('invoices.edit', $invoice) }}"><x-icon name="edit"/>Edit Invoice</a>
    <button class="button button-primary" type="button" data-print><x-icon name="print"/>Cetak Invoice</button>
@endsection
@section('content')
    <div class="detail-status-bar">
        <div><x-status :status="$invoice->status"/>@if($invoice->isOverdue())<span class="overdue">Melewati jatuh tempo</span>@endif</div>
        <form action="{{ route('invoices.status', $invoice) }}" method="POST" class="status-form">@csrf @method('PATCH')<label for="payment-status">Status pembayaran</label><select id="payment-status" name="status">@foreach(\App\Models\Invoice::STATUSES as $value => $label)<option value="{{ $value }}" @selected($invoice->status === $value)>{{ $label }}</option>@endforeach</select><button type="submit" class="button button-secondary">Perbarui</button></form>
    </div>
    @include('invoices.partials.document')
    <p class="print-hint"><x-icon name="info"/>Pilih “Simpan sebagai PDF” pada dialog cetak untuk mengunduh dokumen. Gunakan kertas A4 dan nonaktifkan header/footer browser.</p>
    <noscript><p>Untuk mencetak, gunakan menu Cetak pada browser (⌘P / Ctrl+P).</p></noscript>
@endsection
