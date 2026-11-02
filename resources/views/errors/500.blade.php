@extends('layouts.app')
@section('title', 'Terjadi kendala pada sistem')
@section('description', 'Permintaan belum dapat diproses. Silakan coba kembali.')
@section('eyebrow', 'KESALAHAN 500')
@section('content')
    <a class="button button-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
@endsection
