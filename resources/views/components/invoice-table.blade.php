@props(['invoices', 'filtered' => false])
@if($invoices->isEmpty())
    <div class="empty-state">
        <div class="empty-icon"><x-icon name="file"/></div>
        <h3>{{ $filtered ? 'Invoice tidak ditemukan' : 'Mulai dengan invoice pertama Anda' }}</h3>
        <p>{{ $filtered ? 'Coba kata kunci atau status pembayaran yang berbeda.' : 'Buat invoice, susun rincian tagihan, dan pantau pembayaran dalam satu tempat.' }}</p>
        @if($filtered)<a class="button button-secondary" href="{{ route('invoices.index') }}">Hapus filter</a>
        @else<a class="button button-primary" href="{{ route('invoices.create') }}"><x-icon name="plus"/>Buat Invoice</a>@endif
    </div>
@else
    <div class="table-scroll" tabindex="0" role="region" aria-label="Daftar invoice, geser untuk melihat seluruh kolom">
        <table class="invoice-table">
            <thead><tr><th>Nomor Invoice</th><th>Nama Pelanggan</th><th>Tanggal Invoice</th><th>Jatuh Tempo</th><th class="align-right">Total Tagihan</th><th>Status</th><th class="align-right">Aksi</th></tr></thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td><a class="invoice-link" href="{{ route('invoices.show', $invoice) }}">{{ $invoice->invoice_number }}</a></td>
                        <td class="customer-cell">{{ $invoice->customer_name }}</td>
                        <td class="muted">{{ $invoice->invoice_date->translatedFormat('d M Y') }}</td>
                        <td @class(['muted', 'overdue' => $invoice->isOverdue()])>{{ $invoice->due_date->translatedFormat('d M Y') }}@if($invoice->isOverdue())<small>Lewat jatuh tempo</small>@endif</td>
                        <td class="align-right"><x-money :value="$invoice->total"/></td>
                        <td><x-status :status="$invoice->status"/></td>
                        <td><div class="row-actions">
                            <a class="icon-button" href="{{ route('invoices.show', $invoice) }}" aria-label="Lihat {{ $invoice->invoice_number }}" title="Lihat invoice"><x-icon name="arrow"/></a>
                            <a class="icon-button" href="{{ route('invoices.edit', $invoice) }}" aria-label="Edit {{ $invoice->invoice_number }}" title="Edit invoice"><x-icon name="edit"/></a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" data-confirm="Hapus invoice {{ $invoice->invoice_number }} beserta seluruh itemnya? Tindakan ini tidak dapat dibatalkan.">
                                @csrf @method('DELETE')
                                <button class="icon-button danger" type="submit" aria-label="Hapus {{ $invoice->invoice_number }}" title="Hapus invoice"><x-icon name="trash"/></button>
                            </form>
                        </div></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
