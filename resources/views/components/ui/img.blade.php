@props(['src'])

<img src="{{ $src }}" {{ $attributes->merge(['class' => '']) }} loading="lazy" />
