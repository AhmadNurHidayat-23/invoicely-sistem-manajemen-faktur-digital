<aside class="form-summary">
    <section class="panel summary-card">
        <div class="summary-heading"><h2>Ringkasan invoice</h2><span class="currency-label">IDR</span></div>
        <div class="field"><label for="status">Status pembayaran<span class="required-mark" aria-hidden="true">*</span></label><select name="status" id="status" required>@foreach(\App\Models\Invoice::STATUSES as $value => $label)<option value="{{ $value }}" @selected(old('status', $invoice->status ?? 'draft') === $value)>{{ $label }}</option>@endforeach</select></div>
        <x-field name="tax_percentage" label="Pajak (%) · opsional" type="number" :value="$invoice->exists ? $invoice->taxRate() : '0'" min="0" max="100" step="0.01" hint="Gunakan 0 jika tidak dikenakan pajak."/>
        <div class="calculation"><div><span>Subtotal</span><output data-subtotal>Rp 0</output></div><div><span>Pajak <span data-tax-label>(0%)</span></span><output data-tax>Rp 0</output></div><div class="calculation-total"><span>Total tagihan</span><output data-total>Rp 0</output></div></div>
        <p class="summary-note">Pajak dibulatkan ke Rupiah terdekat. Nilai akhir dihitung kembali saat disimpan.</p>
        <button class="button button-primary save-invoice" type="submit"><x-icon name="check"/>{{ $invoice->exists ? 'Simpan Perubahan' : 'Simpan Invoice' }}</button>
        <a class="cancel-link" href="{{ $invoice->exists ? route('invoices.show', $invoice) : route('invoices.index') }}">Batalkan</a>
    </section>
    <p class="required-note"><span class="required-mark">*</span> Menandai kolom yang wajib diisi.</p>
</aside>
