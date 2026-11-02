@php
    $items = old('items', $invoice->exists ? $invoice->items->map->only(['item_name', 'quantity', 'unit_price'])->all() : [['item_name' => '', 'quantity' => 1, 'unit_price' => 0]]);
    $items = is_array($items) && count($items) ? array_filter(array_slice($items, 0, 100, true), 'is_array') : [['item_name' => '', 'quantity' => 1, 'unit_price' => 0]];
    $items = $items ?: [['item_name' => '', 'quantity' => 1, 'unit_price' => 0]];
@endphp
<section class="panel form-section items-section">
    <div class="form-section-title"><span class="step-number">03</span><div><h2>Rincian tagihan</h2><p>Harga dalam Rupiah bulat. Tambahkan hingga 100 item.</p></div></div>
    <div class="item-labels"><span>Produk atau jasa</span><span>Jumlah</span><span>Harga satuan (Rp)</span><span class="align-right">Total</span><span></span></div>
    <div data-items>
        @foreach($items as $key => $item)
            <x-item-row :index="$key" :item="$item"/>
        @endforeach
    </div>
    <template id="item-template"><x-item-row index="__INDEX__" :item="['item_name' => '', 'quantity' => 1, 'unit_price' => 0]"/></template>
    <button class="button button-secondary add-item" type="button" data-add-item><x-icon name="plus"/>Tambah Item</button>
    <p class="field-hint" data-item-message aria-live="polite">Minimal satu item. Jumlah harus bilangan bulat antara 1–1.000.</p>
    <noscript><p class="field-hint">Aktifkan JavaScript untuk menambah atau menghapus baris dan melihat pratinjau total. Penyimpanan serta perhitungan server tetap tersedia.</p></noscript>
</section>
