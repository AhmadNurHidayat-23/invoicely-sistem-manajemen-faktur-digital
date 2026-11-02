@props(['label', 'icon', 'value', 'caption', 'currency' => false])
<article class="stat-card">
    <div class="stat-label"><h2>{{ $label }}</h2><x-icon :name="$icon"/></div>
    <p class="stat-value">@if($currency)<small>Rp</small> {{ number_format((int) $value, 0, ',', '.') }}@else{{ number_format((int) $value, 0, ',', '.') }}@endif</p>
    <p class="stat-caption">{{ $caption }}</p>
</article>
