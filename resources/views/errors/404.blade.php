@extends('layouts.app')
@section('title', 'Halaman tidak ditemukan')
@section('description', 'Halaman atau invoice yang Anda cari tidak tersedia.')
@section('eyebrow', 'KESALAHAN 404')
@section('content')
    <a class="button button-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
@endsection
