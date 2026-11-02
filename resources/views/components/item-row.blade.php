@props(['index', 'item'])
@php
    $item = array_map(fn ($value) => is_scalar($value) ? (string) $value : '', $item);
@endphp
<div class="item-row" data-item-row>
    <div class="item-name"><label class="mobile-item-label sr-only-desktop" for="item-{{ $index }}-name">Produk atau jasa</label><input id="item-{{ $index }}-name" name="items[{{ $index }}][item_name]" value="{{ $item['item_name'] ?? '' }}" placeholder="Nama produk atau jasa" aria-label="Nama produk atau jasa item {{ is_numeric($index) ? $index + 1 : '__NUMBER__' }}" required maxlength="255">@error('items.'.$index.'.item_name')<small class="field-error">{{ $message }}</small>@enderror</div>
    <div><label class="mobile-item-label sr-only-desktop" for="item-{{ $index }}-quantity">Jumlah</label><input id="item-{{ $index }}-quantity" type="number" name="items[{{ $index }}][quantity]" value="{{ $item['quantity'] ?? 1 }}" min="1" max="1000" step="1" aria-label="Jumlah item {{ is_numeric($index) ? $index + 1 : '__NUMBER__' }}" required data-quantity>@error('items.'.$index.'.quantity')<small class="field-error">{{ $message }}</small>@enderror</div>
    <div><label class="mobile-item-label sr-only-desktop" for="item-{{ $index }}-price">Harga satuan (Rp)</label><input id="item-{{ $index }}-price" type="number" name="items[{{ $index }}][unit_price]" value="{{ $item['unit_price'] ?? 0 }}" min="0" max="999999999" step="1" aria-label="Harga satuan item {{ is_numeric($index) ? $index + 1 : '__NUMBER__' }}" required data-price>@error('items.'.$index.'.unit_price')<small class="field-error">{{ $message }}</small>@enderror</div>
    <output class="item-total" data-line-total aria-label="Total harga item">Rp {{ number_format((int) ($item['quantity'] ?? 0) * (int) ($item['unit_price'] ?? 0), 0, ',', '.') }}</output>
    <button type="button" class="icon-button danger remove-item" data-remove-item aria-label="Hapus item"><x-icon name="trash"/></button>
</div>
