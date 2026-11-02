@extends('layouts.app')
@section('title', 'Dashboard')
@section('description', 'Seluruh tagihan Anda, dalam satu pandangan.')
@section('actions')
    <a class="button button-primary" href="{{ route('invoices.create') }}"><x-icon name="plus"/>Buat Invoice</a>
@endsection
@section('content')
    <section class="stats-grid" aria-label="Statistik invoice">
        <x-stat-card label="Total Invoice" icon="file" :value="$stats->total_count" caption="Seluruh invoice yang dibuat"/>
        <x-stat-card label="Invoice Lunas" icon="check" :value="$stats->paid_count" caption="Pembayaran telah diterima"/>
        <x-stat-card label="Invoice Belum Lunas" icon="clock" :value="$stats->unpaid_count" caption="Menunggu pembayaran, di luar draft"/>
        <x-stat-card label="Total Nilai Invoice" icon="wallet" :value="$stats->total_value" caption="Akumulasi tagihan, termasuk draft" :currency="true"/>
    </section>
    <section class="overview-note">
        <div class="overview-symbol"><x-icon :name="$overdueCount ? 'clock' : 'check'"/></div>
        <div><strong>{{ $overdueCount ? $overdueCount.' invoice melewati jatuh tempo' : 'Pencatatan rapi, penagihan lebih mudah.' }}</strong><p>{{ $overdueCount ? 'Tinjau tagihan yang belum lunas untuk menindaklanjuti pembayaran.' : 'Kelola rincian tagihan dan status pembayaran dari ruang kerja Anda.' }}</p></div>
        <a href="{{ route('invoices.index', $overdueCount ? ['status' => 'unpaid'] : []) }}">Lihat invoice<x-icon name="arrow"/></a>
    </section>
    <section class="panel">
        <div class="section-heading"><div><h2>Invoice Terbaru <span class="count-label">{{ $invoices->count() }}</span></h2><p>Daftar invoice yang terakhir Anda buat.</p></div><a class="text-link" href="{{ route('invoices.index') }}">Lihat semua<x-icon name="arrow"/></a></div>
        <x-invoice-table :invoices="$invoices"/>
        @if($invoices->isNotEmpty())<div class="panel-footnote">Menampilkan {{ $invoices->count() }} invoice terbaru dari {{ $stats->total_count }} invoice.</div>@endif
    </section>
    <div class="dashboard-bottom"><x-icon name="info"/><p>Detail yang akurat untuk setiap transaksi. Invoice dapat dicetak atau disimpan sebagai PDF melalui browser.</p></div>
@endsection
