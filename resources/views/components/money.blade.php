@props(['value' => 0])
<span {{ $attributes->class('money') }}>Rp {{ number_format((int) $value, 0, ',', '.') }}</span>
