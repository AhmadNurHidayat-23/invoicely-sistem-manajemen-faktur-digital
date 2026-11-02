@extends('layouts.app')
@section('title', 'Sesi telah berakhir')
@section('description', 'Muat ulang halaman, lalu kirim formulir kembali.')
@section('eyebrow', 'KESALAHAN 419')
@section('content')
    <a class="button button-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
@endsection
