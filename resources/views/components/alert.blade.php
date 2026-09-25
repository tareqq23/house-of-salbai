@props(['type' => 'info', 'class' => ''])
@php
$classes = 'alert-custom ' . $class;
@endphp
<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
