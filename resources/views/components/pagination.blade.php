@props(['paginator'])
@if($paginator->total())
    <div class="pagination-bar">
        <p>Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} invoice</p>
        @if($paginator->hasPages())
            <nav class="pagination" aria-label="Halaman daftar invoice">
                @if($paginator->onFirstPage())<span class="button button-secondary disabled" aria-disabled="true">Sebelumnya</span>@else<a class="button button-secondary" href="{{ $paginator->previousPageUrl() }}">Sebelumnya</a>@endif
                <span>{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
                @if($paginator->hasMorePages())<a class="button button-secondary" href="{{ $paginator->nextPageUrl() }}">Berikutnya</a>@else<span class="button button-secondary disabled" aria-disabled="true">Berikutnya</span>@endif
            </nav>
        @endif
    </div>
@endif
