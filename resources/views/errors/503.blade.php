@extends('layouts.app')
@section('title', 'Sistem sedang dipelihara')
@section('description', 'Silakan kembali beberapa saat lagi.')
@section('eyebrow', 'KESALAHAN 503')
@section('content')
    <a class="button button-primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
@endsection
