@extends('layouts.app')
@section('title', 'Semua Invoice')
@section('breadcrumb', 'Semua Invoice')
@section('eyebrow', 'KELOLA PENAGIHAN')
@section('description', 'Temukan, kelola, dan pantau setiap invoice Anda.')
@section('actions')
    <a class="button button-primary" href="{{ route('invoices.create') }}"><x-icon name="plus"/>Buat Invoice</a>
@endsection
@section('content')
    <section class="panel">
        <form class="filter-bar" action="{{ route('invoices.index') }}" method="GET">
            <div class="search-field"><label class="sr-only" for="q">Cari nomor invoice atau nama pelanggan</label><x-icon name="search"/><input id="q" name="q" type="search" maxlength="100" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nomor invoice atau nama pelanggan..."></div>
            <div class="status-filter"><label class="sr-only" for="status">Filter status pembayaran</label><select id="status" name="status"><option value="">Semua status</option>@foreach(\App\Models\Invoice::STATUSES as $value => $label)<option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>@endforeach</select></div>
            <button class="button button-secondary" type="submit">Terapkan</button>
            @if(!empty($filters['q']) || !empty($filters['status']))<a class="reset-link" href="{{ route('invoices.index') }}">Reset</a>@endif
        </form>
        <div class="list-summary"><span>{{ $invoices->total() }} invoice ditemukan</span><span>Terbaru terlebih dahulu</span></div>
        <x-invoice-table :invoices="$invoices" :filtered="!empty($filters['q']) || !empty($filters['status'])"/>
        <x-pagination :paginator="$invoices"/>
    </section>
@endsection
