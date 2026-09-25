@props(['variant' => 'primary', 'class' => ''])
@php
$base = $variant === 'primary' ? 'btn-hos' : 'btn-outline-hos';
@endphp
<button {{ $attributes->merge(['class' => trim($base.' '.$class)]) }}>
    {{ $slot }}
</button>
