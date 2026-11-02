<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Invoicely — Sistem Informasi Manajemen Invoice dan Penagihan Digital.">
    <title>@yield('title', 'Dashboard') — Invoicely</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main">Langsung ke konten</a>
    <aside class="sidebar" id="navigation" aria-label="Navigasi utama">
        <a class="brand" href="{{ route('dashboard') }}" aria-label="Invoicely, halaman dashboard"><span class="brand-mark">i<span>•</span></span>Invoicely<span class="brand-dot">.</span></a>
        <p class="nav-label">RUANG KERJA</p>
        <nav>
            <a href="{{ route('dashboard') }}" @class(['nav-link', 'active' => request()->routeIs('dashboard')]) @if(request()->routeIs('dashboard')) aria-current="page" @endif><x-icon name="grid"/>Dashboard</a>
            <a href="{{ route('invoices.index') }}" @class(['nav-link', 'active' => request()->routeIs('invoices.index', 'invoices.show', 'invoices.edit')]) @if(request()->routeIs('invoices.index')) aria-current="page" @endif><x-icon name="file"/>Semua Invoice</a>
            <a href="{{ route('invoices.create') }}" @class(['nav-link', 'active' => request()->routeIs('invoices.create')]) @if(request()->routeIs('invoices.create')) aria-current="page" @endif><x-icon name="plus"/>Buat Invoice</a>
        </nav>
        <div class="sidebar-bottom">
            <div class="local-note"><span class="status-dot"></span>Ruang kerja lokal</div>
            <p>Penagihan tertata.<br>Fokus pada pekerjaan Anda.</p>
            <div class="workspace"><span class="workspace-avatar">IN</span><div><strong>Invoicely</strong><small>Manajemen invoice digital</small></div></div>
        </div>
    </aside>
    <div class="app-shell">
        <div class="topbar">
            <button class="icon-button menu-toggle" type="button" data-menu-toggle aria-controls="navigation" aria-expanded="false" aria-label="Buka navigasi"><x-icon name="menu"/></button>
            <div class="breadcrumb">Ruang kerja <span>/</span> <strong>@yield('breadcrumb', 'Dashboard')</strong></div>
            <div class="topbar-date">{{ now()->translatedFormat('l, d F Y') }}</div>
        </div>
        <main id="main" class="main-content">
            <header class="page-header">
                <div><p class="eyebrow">@yield('eyebrow', 'RINGKASAN RUANG KERJA')</p><h1>@yield('title', 'Dashboard')</h1><p class="page-description">@yield('description')</p></div>
                <div class="header-actions">@yield('actions')</div>
            </header>
            <x-notifications/>
            @yield('content')
            <footer class="app-footer"><span>© {{ now()->year }} Invoicely</span><span>Sistem manajemen invoice & penagihan digital</span></footer>
        </main>
    </div>
</body>
</html>
